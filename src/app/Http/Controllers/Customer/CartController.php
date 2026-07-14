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
        $cart = session()->get('cart', []);
        $cartItems = [];
        $total = 0;

        foreach ($cart as $cartItemId => $item) {
            $cartItems[] = $item;
            $total += $item['subtotal'];
        }

        $addresses = auth()->user()->addresses;

        return view('customer.cart', compact('cartItems', 'total', 'addresses'));
    }

    public function add(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        
        // Collect options
        $options = $request->input('options', []);
        $price = $product->price;
        
        // Calculate extra charges
        if (isset($options['extra_shot']) && $options['extra_shot'] === 'Yes') {
            $price += 5000;
        }

        // Generate unique cart item ID based on product ID and options
        $cartItemId = $product->id . '_' . md5(json_encode($options));

        if (isset($cart[$cartItemId])) {
            $cart[$cartItemId]['quantity']++;
            $cart[$cartItemId]['subtotal'] = $cart[$cartItemId]['quantity'] * $cart[$cartItemId]['price'];
        } else {
            $cart[$cartItemId] = [
                'product' => $product,
                'quantity' => 1,
                'price' => $price,
                'subtotal' => $price,
                'options' => $options,
                'cart_item_id' => $cartItemId,
            ];
        }

        session()->put('cart', $cart);

        return back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function update(Request $request)
    {
        if ($request->quantities) {
            $cart = session()->get('cart');

            foreach ($request->quantities as $cartItemId => $quantity) {
                if (isset($cart[$cartItemId]) && $quantity > 0) {
                    $cart[$cartItemId]['quantity'] = $quantity;
                    $cart[$cartItemId]['subtotal'] = $cart[$cartItemId]['price'] * $quantity;
                }
            }

            session()->put('cart', $cart);
        }

        return back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove($cartItemId)
    {
        $cart = session()->get('cart');

        if (isset($cart[$cartItemId])) {
            unset($cart[$cartItemId]);
            session()->put('cart', $cart);
        }

        return back()->with('success', 'Produk dihapus dari keranjang!');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'delivery_address' => 'nullable|string|max:500',
            'delivery_lat' => 'required|numeric',
            'delivery_lng' => 'required|numeric',
            'payment_method' => 'required|in:qris,cod',
        ]);

        $cart = session('cart', []);

        if (empty($cart)) {
            return back()->with('error', 'Keranjang kosong!');
        }

        // If delivery_address is empty, try to get it from hidden fields (address book)
        $deliveryAddress = $request->delivery_address;
        if (empty($deliveryAddress)) {
            // Find matching address from user's address book by coordinates
            $address = auth()->user()->addresses()
                ->where('lat', $request->delivery_lat)
                ->where('lng', $request->delivery_lng)
                ->first();
            $deliveryAddress = $address ? $address->full_address : 'Alamat dari peta';
        }

        $total = 0;
        $shippingFee = 10000; // Flat fee

        // Create the order
        $order = Order::create([
            'order_code' => Order::generateCode(),
            'user_id' => auth()->id(),
            'status' => 'pending',
            'total_price' => 0,
            'shipping_fee' => $shippingFee,
            'notes' => $request->notes,
            'delivery_address' => $deliveryAddress,
            'delivery_lat' => $request->delivery_lat,
            'delivery_lng' => $request->delivery_lng,
            'payment_method' => $request->payment_method,
            'payment_status' => 'unpaid',
        ]);

        foreach ($cart as $cartItemId => $item) {
            $product = $item['product'];
            if ($product && $product->is_available) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'options' => $item['options'] ?? null,
                ]);
                $total += $item['subtotal'];
            }
        }

        $order->update(['total_price' => $total]);

        // Clear cart
        session()->forget('cart');

        return redirect()->route('customer.orders.show', $order)->with('success', 'Pesanan berhasil dibuat! Kode pesanan: ' . $order->order_code);
    }
}
