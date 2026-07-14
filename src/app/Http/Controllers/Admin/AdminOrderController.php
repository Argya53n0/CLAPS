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

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,preparing,delivery,completed,cancelled'
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
