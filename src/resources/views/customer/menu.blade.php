@extends('customer.layout')

@section('title', 'Menu - Claps Coffee')

@section('content')
    <div class="max-w-6xl mx-auto px-6 lg:px-12 py-12">
        {{-- Header --}}
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-extrabold font-serif text-gray-900 tracking-tight mb-3">Our Menu</h1>
            <p class="text-gray-500 text-[15px] font-medium max-w-lg mx-auto">Handcrafted with passion. Every cup tells a story of quality and care.</p>
        </div>

        {{-- Category Tabs --}}
        <div class="flex items-center justify-center gap-2 mb-10 overflow-x-auto pb-2 hide-scrollbar">
            @php
                $categories = [
                    'all' => 'All Items',
                    'coffee' => '☕ Coffee',
                    'non_coffee' => '🍵 Non-Coffee',
                    'snack' => '🥐 Snack',
                    'food' => '🍽️ Food',
                ];
            @endphp
            @foreach($categories as $value => $label)
                <a href="{{ route('menu', ['category' => $value]) }}"
                   class="px-6 py-2.5 rounded-full text-[13px] font-semibold transition-all whitespace-nowrap border {{ $currentCategory === $value ? 'bg-[#8C4A15] text-white border-[#8C4A15] shadow-md' : 'bg-white text-gray-600 border-[#EBE1D7] hover:border-[#8C4A15] hover:text-[#8C4A15]' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($products as $product)
                <div class="bg-white rounded-3xl border border-[#EBE1D7] overflow-hidden shadow-sm hover:shadow-lg transition-all group">
                    {{-- Image --}}
                    <div class="aspect-[4/3] bg-[#F5F2F0] relative overflow-hidden">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg class="w-12 h-12 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="9" y1="2" x2="9" y2="4"/><line x1="15" y1="2" x2="15" y2="4"/></svg>
                            </div>
                        @endif
                        {{-- Category Badge --}}
                        <div class="absolute top-4 left-4">
                            @php
                                $catStyle = [
                                    'coffee' => 'bg-[#8C4A15] text-white',
                                    'non_coffee' => 'bg-[#138A49] text-white',
                                    'snack' => 'bg-[#C46A4F] text-white',
                                    'food' => 'bg-[#5B7553] text-white',
                                ];
                                $catLabel = ['coffee' => 'Coffee', 'non_coffee' => 'Non-Coffee', 'snack' => 'Snack', 'food' => 'Food'];
                            @endphp
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase {{ $catStyle[$product->category] ?? 'bg-gray-800 text-white' }}">
                                {{ $catLabel[$product->category] ?? ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-6">
                        <h3 class="text-lg font-bold font-serif text-gray-900 mb-1">{{ $product->name }}</h3>
                        <p class="text-[13px] text-gray-500 mb-4 line-clamp-2">{{ $product->description ?: 'A delicious handcrafted item.' }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="text-xl font-extrabold text-[#8C4A15] font-serif">{{ $product->formatted_price }}</div>

                            @auth
                                <form action="{{ route('customer.cart.add', $product) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-5 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[12px] font-bold transition-colors flex items-center gap-1.5 shadow-sm">
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                        Add
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[12px] font-bold transition-colors shadow-sm">
                                    Login to Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                    <p class="text-gray-500 text-[15px] font-medium">Belum ada produk tersedia di kategori ini.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-10 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
@endsection
