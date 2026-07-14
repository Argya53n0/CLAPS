<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cart = session('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product) {
                $subtotal = $product->price * $item['quantity'];
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            }
        }

        return view('customer.cart', compact('cartItems', 'total'));
    }

    public function add(Product $product)
    {
        if (!$product->is_available) {
            return back()->with('error', 'Produk ini sedang tidak tersedia.');
        }

        $cart = session('cart', []);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = ['quantity' => 1];
        }

        session(['cart' => $cart]);

        return back()->with('success', $product->name . ' ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        $cart = session('cart', []);

        foreach ($request->quantities as $productId => $quantity) {
            if ($quantity <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['quantity'] = (int)$quantity;
            }
        }

        session(['cart' => $cart]);

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove(Product $product)
    {
        $cart = session('cart', []);
        unset($cart[$product->id]);
        session(['cart' => $cart]);

        return back()->with('success', $product->name . ' dihapus dari keranjang.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        $total = 0;

        // Create the order
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
            'notes' => $request->notes,
        ]);

        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
            if ($product && $product->is_available) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
                $total += ($product->price * $item['quantity']);
            }
        }

        $order->update(['total_price' => $total]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('customer.orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Kode pesanan: ' . $order->order_code);
    }
}
