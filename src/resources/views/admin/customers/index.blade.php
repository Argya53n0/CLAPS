@extends('admin.layout')

@section('title', 'Customers Management')
@section('header', '')

@section('content')
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 mt-2">
        <div>
            <h1 class="text-4xl font-extrabold font-serif text-gray-900 tracking-tight mb-2">Customers</h1>
            <p class="text-[15px] text-gray-500 font-medium">Manage registered users, view order history, and track loyalty.</p>
        </div>
        <div class="flex items-center gap-3">
            <div class="px-5 py-3 bg-[#FCF8F2] border border-[#EBE1D7] text-[#8C4A15] rounded-xl text-[14px] font-bold shadow-sm flex items-center gap-2">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Total Users: {{ $customers->total() }}
            </div>
            <button class="px-5 py-3 bg-white border border-[#EBE1D7] hover:bg-gray-50 text-gray-700 rounded-xl text-[14px] font-bold shadow-sm flex items-center gap-2 transition-colors">
                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Export CSV
            </button>
        </div>
    </div>

    {{-- Main Table Container --}}
    <div class="bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden mb-6">
        
        {{-- Toolbar --}}
        <div class="px-6 py-5 border-b border-[#EBE1D7] flex flex-col md:flex-row justify-between items-center gap-4 bg-white">
            <div class="relative w-full md:w-96">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="h-4 w-4 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                </div>
                <input type="text" placeholder="Search customers by name or email..." class="w-full bg-[#FCF8F2] border-none text-[13px] text-gray-900 rounded-xl pl-11 pr-4 py-3 focus:ring-1 focus:ring-[#8C4A15] placeholder-gray-400">
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto">
                <button class="px-4 py-2.5 bg-white border border-[#EBE1D7] rounded-xl text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2 flex-1 md:flex-none justify-center">
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                    Filters
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b-2 border-gray-100 text-[12px] uppercase tracking-wider text-gray-400 font-bold bg-white">
                        <th class="py-5 pl-8 pr-4">Customer Details</th>
                        <th class="py-5 px-4 text-center">Total Orders</th>
                        <th class="py-5 px-4">Joined Date</th>
                        <th class="py-5 px-4 text-center">Status</th>
                        <th class="py-5 pl-4 pr-8 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[14px]">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            {{-- Customer --}}
                            <td class="py-5 pl-8 pr-4">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-[#FDF4EB] text-[#8C4A15] flex items-center justify-center text-[14px] font-bold font-serif shrink-0 border border-[#EBE1D7]">
                                        {{ substr($customer->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[15px] mb-0.5">{{ $customer->name }}</div>
                                        <div class="text-[13px] text-gray-500">{{ $customer->email }}</div>
                                    </div>
                                </div>
                            </td>
                            
                            {{-- Total Orders --}}
                            <td class="py-5 px-4 text-center">
                                <span class="inline-flex items-center justify-center min-w-[2.5rem] h-9 px-3 rounded-lg {{ $customer->orders_count > 0 ? 'bg-[#FCF8F2] text-[#8C4A15] border border-[#EBE1D7]' : 'bg-gray-50 text-gray-400 border border-gray-100' }} font-bold text-[14px]">
                                    {{ $customer->orders_count }}
                                </span>
                            </td>
                            
                            {{-- Date --}}
                            <td class="py-5 px-4">
                                <div class="text-gray-900 font-medium">{{ $customer->created_at->format('d M Y') }}</div>
                                <div class="text-[12px] text-gray-500 mt-0.5">{{ $customer->created_at->diffForHumans() }}</div>
                            </td>

                            {{-- Status --}}
                            <td class="py-5 px-4 text-center">
                                <span class="px-3 py-1 bg-[#D1F4E0] text-[#138A49] rounded-full text-[11px] font-bold tracking-wide uppercase">
                                    Active
                                </span>
                            </td>
                            
                            {{-- Actions --}}
                            <td class="py-5 pl-4 pr-8 text-right">
                                <button class="w-9 h-9 rounded-lg bg-white border border-[#EBE1D7] text-gray-400 hover:text-[#8C4A15] hover:border-[#8C4A15] flex items-center justify-center transition-colors shadow-sm ml-auto" title="View Profile">
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg class="w-12 h-12 text-gray-300 mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    <p class="font-medium text-[15px]">No customers found.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination --}}
        @if($customers->hasPages())
            <div class="px-8 py-5 flex items-center justify-between border-t border-[#EBE1D7] bg-gray-50/30">
                <div class="text-[13px] font-bold text-gray-500">
                    Showing {{ $customers->firstItem() ?? 0 }}–{{ $customers->lastItem() ?? 0 }} of {{ $customers->total() }} users
                </div>
                <div class="flex items-center gap-1.5">
                    {{-- Prev --}}
                    @if ($customers->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </span>
                    @else
                        <a href="{{ $customers->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </a>
                    @endif

                    {{-- Current --}}
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#8C4A15] text-white font-bold text-[13px] shadow-sm">{{ $customers->currentPage() }}</span>
                    
                    {{-- Next --}}
                    @if($customers->hasMorePages())
                        <a href="{{ $customers->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white font-bold text-[13px] shadow-sm">{{ $customers->currentPage() + 1 }}</a>
                        <a href="{{ $customers->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white shadow-sm">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </div>
@endsection
