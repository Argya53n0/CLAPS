<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items.product')->latest();

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        $orders = $query->paginate(10);
        $currentStatus = $request->status ?? 'all';

        $openOrdersCount = Order::whereNotIn('status', ['completed', 'cancelled'])->count();
        $avgPreparationTime = '12 min'; // Mocked

        return view('admin.orders.index', compact('orders', 'currentStatus', 'openOrdersCount', 'avgPreparationTime'));
    }

    public function show(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.show', compact('order'));
    }

    public function print(Order $order)
    {
        $order->load(['user', 'items.product']);
        return view('admin.orders.print', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,delivery,completed,cancelled',
            'cancellation_reason' => 'nullable|string|max:255'
        ]);

        $data = ['status' => $request->status];
        if ($request->status === 'cancelled') {
            $data['cancellation_reason'] = $request->cancellation_reason;
        } else {
            $data['cancellation_reason'] = null; // Clear if un-cancelled
        }

        $order->update($data);

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
