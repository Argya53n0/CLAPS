@extends('admin.layout')

@section('title', 'Menu Management')
@section('header', '')

@section('content')
    {{-- Header Section --}}
    <div class="flex flex-col md:flex-row md:items-end justify-between mb-8 gap-4 mt-2">
        <div>
            <h1 class="text-4xl font-extrabold font-serif text-gray-900 tracking-tight mb-2">Menu Management</h1>
            <p class="text-[15px] text-gray-500 font-medium">Manage your coffee offerings, pastries, and seasonal specials.</p>
        </div>
        <a href="{{ route('admin.menu.create') }}" class="px-6 py-3 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-semibold transition-all shadow-sm flex items-center gap-2 shrink-0">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Add New Product
        </a>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Total Items --}}
        <div class="bg-white rounded-2xl border border-[#EBE1D7] p-6 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-full bg-[#FDF4EB] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="9" y1="2" x2="9" y2="4"/><line x1="15" y1="2" x2="15" y2="4"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1">Total Items</h3>
                <div class="text-3xl font-extrabold text-gray-900 font-serif leading-none">{{ $totalItems }}</div>
            </div>
        </div>

        {{-- In Stock --}}
        <div class="bg-white rounded-2xl border border-[#EBE1D7] p-6 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-full bg-[#FCF3F0] flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-[#C46A4F]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1">In Stock</h3>
                <div class="text-3xl font-extrabold text-gray-900 font-serif leading-none">{{ $inStock }}</div>
            </div>
        </div>

        {{-- Out of Stock --}}
        <div class="bg-white rounded-2xl border border-[#EBE1D7] p-6 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1">Out of Stock</h3>
                <div class="text-3xl font-extrabold text-gray-900 font-serif leading-none">{{ $outOfStock }}</div>
            </div>
        </div>

        {{-- Best Seller --}}
        <div class="bg-white rounded-2xl border border-[#EBE1D7] p-6 shadow-sm flex items-center gap-5">
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                <svg class="w-5 h-5 text-gray-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>
                </svg>
            </div>
            <div>
                <h3 class="text-[11px] font-bold text-gray-800 uppercase tracking-wider mb-1">Best Seller</h3>
                <div class="text-xl font-bold text-gray-900 font-serif leading-tight">{{ Str::limit($bestSeller, 15) }}</div>
            </div>
        </div>
    </div>

    {{-- Main Content Container --}}
    <div class="bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden p-6 md:p-8">
        
        {{-- Toolbar --}}
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4">
            {{-- Tabs --}}
            <div class="flex items-center gap-1 overflow-x-auto pb-2 lg:pb-0 hide-scrollbar">
                @php
                    $categories = [
                        'all' => 'All Items',
                        'coffee' => 'Espresso',
                        'non_coffee' => 'Filter',
                        'snack' => 'Pastry',
                        'food' => 'Food'
                    ];
                @endphp
                @foreach($categories as $value => $label)
                    <a href="{{ route('admin.menu', ['category' => $value]) }}" 
                       class="px-5 py-2.5 rounded-lg text-[14px] font-semibold transition-all whitespace-nowrap {{ $currentCategory === $value ? 'bg-[#FCF8F2] text-[#8C4A15]' : 'text-gray-500 hover:text-gray-900 hover:bg-gray-50' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            {{-- Action Buttons --}}
            <div class="flex items-center gap-3 shrink-0">
                <button class="px-5 py-2.5 bg-white border border-[#EBE1D7] rounded-xl text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/></svg>
                    Filters
                </button>
                <button class="px-5 py-2.5 bg-white border border-[#EBE1D7] rounded-xl text-[13px] font-bold text-gray-700 hover:bg-gray-50 transition-colors flex items-center gap-2">
                    <svg class="w-4 h-4 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="15" y2="12"/><line x1="3" y1="18" x2="9" y2="18"/></svg>
                    Sort
                </button>
            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse min-w-[800px]">
                <thead>
                    <tr class="border-b-2 border-gray-100 text-[13px] font-bold text-gray-900">
                        <th class="py-4 pr-6">Item</th>
                        <th class="py-4 px-6">Category</th>
                        <th class="py-4 px-6">Price</th>
                        <th class="py-4 px-6">Status</th>
                        <th class="py-4 pl-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50/50 transition-colors group">
                            <td class="py-4 pr-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-14 h-14 rounded-xl bg-[#F5F2F5] shrink-0 border border-gray-100 p-2 flex items-center justify-center">
                                        @if($product->image)
                                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-5 h-5 text-[#A399B6]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-[15px] mb-0.5">{{ $product->name }}</div>
                                        <div class="text-[12px] text-gray-500 line-clamp-1 max-w-[250px]">{{ $product->description ?: 'No description available' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                @php
                                    // Map categories to match design badges
                                    $catMap = [
                                        'coffee' => ['label' => 'Espresso', 'bg' => 'bg-[#FCF4EC]', 'text' => 'text-[#8C4A15]'],
                                        'non_coffee' => ['label' => 'Filter', 'bg' => 'bg-[#FCF4EC]', 'text' => 'text-[#8C4A15]'],
                                        'snack' => ['label' => 'Pastry', 'bg' => 'bg-[#F2F4F2]', 'text' => 'text-gray-700'],
                                        'food' => ['label' => 'Food', 'bg' => 'bg-[#F2F4F2]', 'text' => 'text-gray-700'],
                                    ];
                                    $badge = $catMap[$product->category] ?? ['label' => ucfirst($product->category), 'bg' => 'bg-gray-100', 'text' => 'text-gray-700'];
                                @endphp
                                <span class="px-3 py-1 {{ $badge['bg'] }} {{ $badge['text'] }} rounded-full text-[11px] font-bold tracking-wide">
                                    {{ $badge['label'] }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-[14px] text-gray-700 font-medium">
                                {{ $product->formatted_price }}
                            </td>
                            <td class="py-4 px-6">
                                <form action="{{ route('admin.menu.toggle', $product) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="flex items-center gap-2 group/toggle">
                                        @if($product->is_available)
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#10B981] group-hover/toggle:scale-125 transition-transform"></div>
                                            <span class="text-[13px] font-bold text-gray-700 group-hover/toggle:text-[#10B981] transition-colors">In Stock</span>
                                        @else
                                            <div class="w-1.5 h-1.5 rounded-full bg-[#EF4444] group-hover/toggle:scale-125 transition-transform"></div>
                                            <span class="text-[13px] font-bold text-gray-700 group-hover/toggle:text-[#EF4444] transition-colors">Sold Out</span>
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td class="py-4 pl-6 text-right">
                                <div class="flex items-center justify-end gap-3 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <a href="{{ route('admin.menu.edit', $product) }}" class="text-gray-400 hover:text-[#8C4A15] transition-colors" title="Edit">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                    </a>
                                    <form action="{{ route('admin.menu.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this menu?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><line x1="10" y1="11" x2="10" y2="17"/><line x1="14" y1="11" x2="14" y2="17"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-gray-500">
                                <p class="text-[14px] font-medium">No products found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination --}}
        @if($products->hasPages())
            <div class="mt-8 flex items-center justify-between pt-6 border-t border-gray-100">
                <div class="text-[13px] font-bold text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} products
                </div>
                <div class="flex items-center gap-1.5">
                    {{-- Previous Page Link --}}
                    @if ($products->onFirstPage())
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white cursor-not-allowed">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                        </a>
                    @endif

                    {{-- Pagination Elements (Simplified for demo) --}}
                    <span class="w-9 h-9 flex items-center justify-center rounded-lg bg-[#8C4A15] text-white font-bold text-[13px]">{{ $products->currentPage() }}</span>
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white transition-colors text-[13px] font-bold">{{ $products->currentPage() + 1 }}</a>
                        @if($products->currentPage() + 2 <= $products->lastPage())
                            <span class="w-9 h-9 flex items-center justify-center text-gray-400 font-bold">...</span>
                            <a href="{{ $products->url($products->lastPage()) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white transition-colors text-[13px] font-bold">{{ $products->lastPage() }}</a>
                        @endif
                    @endif

                    {{-- Next Page Link --}}
                    @if ($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-600 hover:bg-gray-50 bg-white transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </a>
                    @else
                        <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-[#EBE1D7] text-gray-300 bg-white cursor-not-allowed">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="9 18 15 12 9 6"/></svg>
                        </span>
                    @endif
                </div>
            </div>
        @endif
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
