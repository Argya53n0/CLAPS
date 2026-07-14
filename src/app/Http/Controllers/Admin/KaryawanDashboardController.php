<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class KaryawanDashboardController extends Controller
{
    public function index()
    {
        $incomingOrders = Order::where('status', 'pending')->count();
        $preparingOrders = Order::where('status', 'preparing')->count();
        $readyOrders = Order::where('status', 'delivery')->count();
        $completedToday = Order::where('status', 'completed')
            ->whereDate('created_at', today())
            ->count();

        $activeOrders = Order::with('user', 'items.product')
            ->whereIn('status', ['pending', 'preparing', 'delivery'])
            ->latest()
            ->get();

        return view('admin.karyawan-dashboard', compact(
            'incomingOrders',
            'preparingOrders',
            'readyOrders',
            'completedToday',
            'activeOrders'
        ));
    }
}
