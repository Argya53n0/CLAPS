@extends('admin.layout')

@section('title', 'Orders Management')
@section('header', '')

@section('content')
    {{-- Header Section --}}
    <div class="mb-6">
        <h1 class="text-3xl font-extrabold font-serif text-[#8C4A15] tracking-tight mb-2">Orders<br>Management</h1>
    </div>

    {{-- Tabs and Stats --}}
    <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-6 gap-4">
        {{-- Tabs --}}
        <div class="flex items-center gap-2 overflow-x-auto pb-2 lg:pb-0 hide-scrollbar bg-white p-2 rounded-xl border border-[#EBE1D7] shadow-sm">
            @php
                $statuses = [
                    'all' => 'All',
                    'pending' => 'Incoming',
                    'preparing' => 'Preparing',
                    'delivery' => 'Ready for Pickup',
                    'completed' => 'Completed'
                ];
            @endphp
            @foreach($statuses as $value => $label)
                <a href="{{ route('admin.orders', ['status' => $value]) }}" 
                   class="px-6 py-2 rounded-lg text-[13px] font-semibold transition-all whitespace-nowrap {{ $currentStatus === $value ? 'bg-white shadow border border-[#EBE1D7] text-[#8C4A15]' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Top Right Stats --}}
        <div class="flex items-center gap-3 shrink-0">
            <div class="bg-white px-5 py-3 rounded-xl border border-[#EBE1D7] shadow-sm flex items-center gap-4">
                <div class="w-8 h-8 rounded-full bg-[#FCF8F2] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div>
                    <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest leading-none mb-1">Avg Preparation</div>
                    <div class="text-[15px] font-extrabold text-gray-900 leading-none">{{ $avgPreparationTime }}</div>
                </div>
            </div>
            <div class="bg-white px-5 py-3 rounded-xl border border-[#EBE1D7] shadow-sm flex items-center gap-4">
                <div class="w-8 h-8 rounded-full bg-[#FCF8F2] flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                </div>
                <div>
                    <div class="text-[9px] font-bold text-gray-500 uppercase tracking-widest leading-none mb-1">Open Orders</div>
                    <div class="text-[15px] font-extrabold text-gray-900 leading-none">{{ $openOrdersCount }}</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-white rounded-2xl border border-[#EBE1D7] shadow-sm overflow-hidden mb-6">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[900px]">
                <thead>
                    <tr class="border-b border-[#EBE1D7] text-[11px] uppercase tracking-wider text-gray-900 font-bold bg-white">
                        <th class="py-5 pl-6 pr-4 w-[15%]">Order ID</th>
                        <th class="py-5 px-4 w-[20%]">Customer</th>
                        <th class="py-5 px-4 w-[15%]">Date & Time</th>
                        <th class="py-5 px-4 w-[20%]">Items</th>
                        <th class="py-5 px-4 w-[10%]">Total</th>
                        <th class="py-5 px-4 w-[12%]">Status</th>
                        <th class="py-5 pl-4 pr-6 text-right w-[8%]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-[#EBE1D7]/50 text-[14px]">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50/30 transition-colors">
                            {{-- Order ID --}}
                            <td class="py-5 pl-6 pr-4">
                                <div class="font-bold text-[#8C4A15]">#{{ $order->order_code }}</div>
                            </td>
                            
                            {{-- Customer --}}
                            <td class="py-5 px-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gray-200 text-gray-600 flex items-center justify-center text-[11px] font-bold shrink-0">
                                        @php
                                            $names = explode(' ', $order->user->name);
                                            $initials = '';
                                            foreach($names as $n) {
                                                $initials .= substr($n, 0, 1);
                                            }
                                            echo strtoupper(substr($initials, 0, 2));
                                        @endphp
                                    </div>
                                        <div>
                                        <div class="font-bold text-gray-900 leading-tight">
                                            @php
                                                $parts = explode(' ', $order->user->name);
                                                echo count($parts) > 1 ? $parts[0] . '<br>' . implode(' ', array_slice($parts, 1)) : $parts[0];
                                            @endphp
                                        </div>
                                        @if($order->delivery_lat && $order->delivery_lng)
                                            <a href="https://www.google.com/maps?q={{ $order->delivery_lat }},{{ $order->delivery_lng }}" target="_blank" class="text-[11px] text-[#8C4A15] hover:underline flex items-center gap-1 mt-1 font-semibold">
                                                <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                                Lihat Rute
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Date & Time --}}
                            <td class="py-5 px-4">
                                <div class="text-gray-900 font-medium leading-tight">
                                    {{ $order->created_at->format('M d,') }}<br>
                                    {{ $order->created_at->format('Y') }}<br>
                                    <span class="text-[11px] text-gray-500 font-normal">{{ $order->created_at->format('h:i A') }}</span>
                                </div>
                            </td>
                            
                            {{-- Items --}}
                            <td class="py-5 px-4">
                                <div class="flex flex-col gap-1.5 items-start">
                                    @foreach($order->items as $item)
                                        <span class="px-2.5 py-1 bg-[#FCF8F2] text-[#8C4A15] rounded-md text-[11px] font-bold">
                                            {{ $item->quantity }}x {{ $item->product->name ?? 'Unknown' }}
                                        </span>
                                    @endforeach
                                </div>
                            </td>
                            
                            {{-- Total --}}
                            <td class="py-5 px-4">
                                <div class="font-extrabold text-gray-900">{{ $order->formatted_total }}</div>
                            </td>
                            
                            {{-- Status Select --}}
                            <td class="py-5 px-4">
                                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="relative group/form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" onchange="this.form.submit()" class="appearance-none w-full bg-[#FCF8F2] border-none text-[#8C4A15] text-[11px] font-bold rounded-full px-3 py-1.5 pr-8 focus:ring-0 cursor-pointer">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Incoming</option>
                                        <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                                        <option value="delivery" {{ $order->status === 'delivery' ? 'selected' : '' }}>Ready for Pickup</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-[#8C4A15]">
                                        <svg class="w-3 h-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                                    </div>
                                </form>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="py-5 pl-4 pr-6 text-right">
                                <button class="px-4 py-2 bg-[#EBE1D7]/40 hover:bg-[#EBE1D7] text-[#8C4A15] rounded-lg text-[12px] font-bold transition-colors">
                                    View<br>Details
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-gray-500">
                                <p class="text-[14px] font-medium">No orders found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination --}}
        @if($orders->hasPages())
            <div class="px-6 py-4 flex items-center justify-between border-t border-[#EBE1D7]">
                <div class="text-[12px] font-bold text-gray-600">
                    Showing {{ $orders->firstItem() ?? 0 }}–{{ $orders->lastItem() ?? 0 }} of {{ $orders->total() }} orders
                </div>
                <div class="flex items-center gap-1.5">
                    {{-- Prev --}}
                    @if ($orders->onFirstPage())
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </a>
                    @endif

                    {{-- Current --}}
                    <span class="w-8 h-8 flex items-center justify-center rounded-lg bg-[#8C4A15] text-white font-bold text-[12px]">{{ $orders->currentPage() }}</span>
                    
                    {{-- Next --}}
                    @if($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white font-bold text-[12px]">{{ $orders->currentPage() + 1 }}</a>
                        <a href="{{ $orders->nextPageUrl() }}" class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <span class="w-8 h-8 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>

    {{-- Bottom Widgets --}}
    <div class="grid grid-cols-1 lg:grid-cols-[1fr_300px] gap-6">
        
        {{-- Real-time Order Volume --}}
        <div class="bg-[#FCF8F2] rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between min-h-[300px]">
            <div class="flex justify-between items-start z-10 relative">
                <h2 class="text-2xl font-extrabold font-serif text-gray-900">Real-time Order Volume</h2>
                <div class="px-3 py-1 bg-[#D1F4E0] text-[#138A49] rounded-full text-[10px] font-bold tracking-wider flex items-center gap-1.5">
                    <div class="w-1.5 h-1.5 rounded-full bg-[#138A49] animate-pulse"></div>
                    LIVE
                </div>
            </div>
            
            {{-- Mock Bar Chart --}}
            <div class="flex items-end gap-2 h-40 mt-12 relative z-10">
                <div class="w-full bg-[#EBE1D7] rounded-t-lg h-[20%]"></div>
                <div class="w-full bg-[#EBE1D7] rounded-t-lg h-[35%]"></div>
                <div class="w-full bg-[#EBE1D7] rounded-t-lg h-[25%]"></div>
                <div class="w-full bg-[#CBA47E] rounded-t-lg h-[50%]"></div>
                <div class="w-full bg-[#CBA47E] rounded-t-lg h-[45%]"></div>
                <div class="w-full bg-[#B5855A] rounded-t-lg h-[65%]"></div>
                <div class="w-full bg-[#B5855A] rounded-t-lg h-[60%]"></div>
                <div class="w-full bg-[#9B6A3B] rounded-t-lg h-[75%]"></div>
                <div class="w-full bg-[#8C4A15] rounded-t-lg h-[90%]"></div>
            </div>
            
            <div class="flex justify-between text-[10px] font-bold text-gray-500 tracking-wider mt-4 z-10 relative">
                <span>06:00 AM</span>
                <span>NOW</span>
            </div>
        </div>

        {{-- Kitchen View Widget --}}
        <div class="bg-[#8C4A15] rounded-3xl p-8 relative overflow-hidden flex flex-col justify-between">
            {{-- Decorative Icon Background --}}
            <svg class="absolute -right-8 -bottom-8 w-48 h-48 text-white opacity-10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1">
                <path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="9" y1="2" x2="9" y2="4"/><line x1="15" y1="2" x2="15" y2="4"/>
            </svg>
            
            <div class="relative z-10">
                <h2 class="text-2xl font-extrabold font-serif text-white mb-3">Kitchen View</h2>
                <p class="text-[13px] text-white/80 font-medium leading-relaxed">
                    Switch to the large-screen barista terminal view for active station prep.
                </p>
            </div>
            
            <button class="mt-8 w-full bg-white text-[#8C4A15] hover:bg-gray-50 py-3 rounded-xl text-[14px] font-bold transition-colors flex items-center justify-center gap-2 relative z-10">
                Launch Terminal
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
            </button>
        </div>

    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
@endsection
