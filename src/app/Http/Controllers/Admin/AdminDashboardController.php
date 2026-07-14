<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $todaySales = Order::whereDate('created_at', today())
            ->where('status', '!=', 'cancelled')
            ->sum('total_price');

        $totalOrders = Order::whereDate('created_at', today())->count();

        $activeOrders = Order::whereIn('status', ['pending', 'preparing'])->count();

        $totalCustomers = User::where('role', 'customer')->count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'todaySales',
            'totalOrders',
            'activeOrders',
            'totalCustomers',
            'recentOrders'
        ))->with('todaySales', 'Rp ' . number_format($todaySales, 0, ',', '.'));
    }
}
