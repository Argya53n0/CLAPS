@extends('admin.layout')

@section('title', 'Overview')
@section('header', '')

@section('content')
    {{-- Header Section --}}
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-serif text-[#8C4A15] tracking-tight mb-2">Welcome Back, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}!</h1>
        <p class="text-[15px] text-gray-500 font-medium">Here is what's happening at your branch today.</p>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 border border-[#EBE1D7] shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-[#FDF4EB] rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-full bg-[#FCF8F2] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2v20M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                </div>
                <h3 class="text-[12px] font-bold text-gray-500 uppercase tracking-widest">Total Sales (Today)</h3>
            </div>
            <div class="text-4xl font-extrabold font-serif text-gray-900 mb-2 relative z-10">{{ $todaySales }}</div>
            <p class="text-[13px] text-[#138A49] font-bold relative z-10 flex items-center gap-1.5 bg-[#D1F4E0] w-fit px-2.5 py-1 rounded-md">
                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
                {{ $totalOrders }} orders today
            </p>
        </div>
        
        <div class="bg-white rounded-3xl p-6 border border-[#EBE1D7] shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-[#FDF4EB] rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-full bg-[#FCF8F2] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <h3 class="text-[12px] font-bold text-gray-500 uppercase tracking-widest">Active Orders</h3>
            </div>
            <div class="text-4xl font-extrabold font-serif text-gray-900 mb-2 relative z-10">{{ $activeOrders }}</div>
            <p class="text-[13px] text-[#C46A4F] font-bold relative z-10 flex items-center gap-1.5 bg-[#FCF3F0] w-fit px-2.5 py-1 rounded-md">
                Pending & Preparing
            </p>
        </div>
        
        <div class="bg-white rounded-3xl p-6 border border-[#EBE1D7] shadow-sm relative overflow-hidden group hover:shadow-md transition-all">
            <div class="absolute -right-4 -bottom-4 w-28 h-28 bg-[#FDF4EB] rounded-full opacity-50 group-hover:scale-110 transition-transform"></div>
            <div class="flex items-center gap-3 mb-4 relative z-10">
                <div class="w-10 h-10 rounded-full bg-[#FCF8F2] flex items-center justify-center">
                    <svg class="w-4 h-4 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                </div>
                <h3 class="text-[12px] font-bold text-gray-500 uppercase tracking-widest">Total Customers</h3>
            </div>
            <div class="text-4xl font-extrabold font-serif text-gray-900 mb-2 relative z-10">{{ $totalCustomers }}</div>
            <p class="text-[13px] text-[#138A49] font-bold relative z-10 flex items-center gap-1.5 bg-[#D1F4E0] w-fit px-2.5 py-1 rounded-md">
                Registered users
            </p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Orders Table --}}
        <div class="lg:col-span-2 bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden flex flex-col">
            <div class="px-8 py-6 border-b border-[#EBE1D7] flex justify-between items-center bg-white">
                <div>
                    <h3 class="text-xl font-extrabold font-serif text-gray-900">Recent Orders</h3>
                    <p class="text-[12px] text-gray-500 font-medium mt-1">Latest transactions from your store.</p>
                </div>
                <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-[#FCF8F2] text-[#8C4A15] rounded-lg text-[12px] font-bold hover:bg-[#FDF4EB] transition-colors">View All</a>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse min-w-[500px]">
                    <thead>
                        <tr class="border-b-2 border-gray-100 bg-white text-[11px] uppercase tracking-wider text-gray-400 font-bold">
                            <th class="px-8 py-4">Customer</th>
                            <th class="px-4 py-4">Amount</th>
                            <th class="px-4 py-4">Status</th>
                            <th class="px-8 py-4 text-right">Time</th>
                        </tr>
                    </thead>
                    <tbody class="text-[14px] text-gray-800 divide-y divide-gray-100">
                        @forelse($recentOrders as $order)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="px-8 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-100 text-gray-600 flex items-center justify-center text-[11px] font-bold shrink-0">
                                        {{ substr($order->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $order->user->name }}</div>
                                        <div class="text-[11px] text-gray-500">#{{ $order->order_code }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-4 font-bold text-gray-900">{{ $order->formatted_total }}</td>
                            <td class="px-4 py-4">
                                @php
                                    $statusConfig = [
                                        'pending' => ['bg' => 'bg-orange-100', 'text' => 'text-orange-800', 'label' => 'Incoming'],
                                        'preparing' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Preparing'],
                                        'delivery' => ['bg' => 'bg-blue-100', 'text' => 'text-blue-800', 'label' => 'Pickup'],
                                        'completed' => ['bg' => 'bg-[#D1F4E0]', 'text' => 'text-[#138A49]', 'label' => 'Completed'],
                                        'cancelled' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Cancelled'],
                                    ];
                                    $cfg = $statusConfig[$order->status] ?? ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => $order->status];
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider {{ $cfg['bg'] }} {{ $cfg['text'] }}">
                                    {{ $cfg['label'] }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right text-[12px] font-medium text-gray-500">
                                {{ $order->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-8 py-12 text-center text-gray-400">
                                <div class="flex flex-col items-center">
                                    <svg class="w-8 h-8 mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    <p class="text-[13px] font-medium">Belum ada pesanan terbaru.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Actions & Marketing --}}
        <div class="flex flex-col gap-6">
            {{-- Quick Actions --}}
            <div class="bg-[#FCF8F2] rounded-3xl p-6 border border-[#EBE1D7] shadow-sm">
                <h3 class="text-lg font-extrabold font-serif text-gray-900 mb-4">Quick Actions</h3>
                <div class="grid grid-cols-2 gap-3">
                    <a href="{{ route('admin.menu.create') }}" class="bg-white hover:bg-[#8C4A15] hover:text-white group border border-[#EBE1D7] rounded-2xl p-4 flex flex-col items-center justify-center text-center transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#FCF8F2] group-hover:bg-white/20 text-[#8C4A15] group-hover:text-white flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        </div>
                        <span class="text-[12px] font-bold text-gray-800 group-hover:text-white">Add Menu</span>
                    </a>
                    <a href="{{ route('admin.orders') }}" class="bg-white hover:bg-[#8C4A15] hover:text-white group border border-[#EBE1D7] rounded-2xl p-4 flex flex-col items-center justify-center text-center transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#FCF8F2] group-hover:bg-white/20 text-[#8C4A15] group-hover:text-white flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        </div>
                        <span class="text-[12px] font-bold text-gray-800 group-hover:text-white">Manage Orders</span>
                    </a>
                    <a href="{{ route('admin.customers') }}" class="bg-white hover:bg-[#8C4A15] hover:text-white group border border-[#EBE1D7] rounded-2xl p-4 flex flex-col items-center justify-center text-center transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#FCF8F2] group-hover:bg-white/20 text-[#8C4A15] group-hover:text-white flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        </div>
                        <span class="text-[12px] font-bold text-gray-800 group-hover:text-white">Customers</span>
                    </a>
                    <button class="bg-white hover:bg-[#8C4A15] hover:text-white group border border-[#EBE1D7] rounded-2xl p-4 flex flex-col items-center justify-center text-center transition-colors">
                        <div class="w-10 h-10 rounded-full bg-[#FCF8F2] group-hover:bg-white/20 text-[#8C4A15] group-hover:text-white flex items-center justify-center mb-2 transition-colors">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                        </div>
                        <span class="text-[12px] font-bold text-gray-800 group-hover:text-white">POS Terminal</span>
                    </button>
                </div>
            </div>

            {{-- Promo / Info Card --}}
            <div class="bg-[#8C4A15] rounded-3xl p-6 relative overflow-hidden flex-1">
                <svg class="absolute -right-8 -top-8 w-32 h-32 text-white opacity-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
                <div class="relative z-10">
                    <h3 class="text-xl font-extrabold font-serif text-white mb-2">New Feature!</h3>
                    <p class="text-[13px] text-white/80 font-medium mb-4 leading-relaxed">
                        Claps Coffee Analytics is coming soon. Prepare to track your best-selling items in detail.
                    </p>
                    <button class="px-4 py-2 bg-white text-[#8C4A15] text-[12px] font-bold rounded-lg hover:bg-gray-50 transition-colors">
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection
