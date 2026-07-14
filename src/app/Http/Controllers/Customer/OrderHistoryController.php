<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderHistoryController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Ensure user can only see their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load('items.product');

        return view('customer.orders.show', compact('order'));
    }

    public function rate(Request $request, Order $order)
    {
        // Ensure user can only rate their own orders
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        // Only completed orders can be rated
        if ($order->status !== 'completed') {
            return back()->with('error', 'Pesanan ini belum selesai.');
        }

        // Prevent double rating
        if ($order->rating) {
            return back()->with('error', 'Anda sudah memberikan penilaian.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $order->update([
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Terima kasih atas penilaian Anda!');
    }

    public function simulatePayment(Order $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Pesanan ini sudah dibayar.');
        }

        $order->update(['payment_status' => 'paid']);

        return back()->with('success', 'Pembayaran berhasil! Status telah diperbarui.');
    }
}
