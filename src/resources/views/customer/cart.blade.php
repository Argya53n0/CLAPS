@extends('customer.layout')

@section('title', 'Keranjang - Claps Coffee')

@section('content')
    <div class="max-w-4xl mx-auto px-6 lg:px-12 py-12">
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight mb-8">Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    <form action="{{ route('customer.cart.update') }}" method="POST" id="cartForm">
                        @csrf
                        @method('PATCH')

                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-2xl border border-[#EBE1D7] p-5 shadow-sm flex items-center gap-5 group">
                                {{-- Image --}}
                                <div class="w-20 h-20 rounded-xl bg-[#F5F2F0] shrink-0 overflow-hidden">
                                    @if($item['product']->image)
                                        <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-900 text-[15px] mb-0.5">{{ $item['product']->name }}</h3>
                                    <p class="text-[13px] text-gray-500">{{ $item['product']->formatted_price }}</p>
                                </div>

                                {{-- Quantity --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <input type="number" name="quantities[{{ $item['product']->id }}]" value="{{ $item['quantity'] }}" min="0" max="99"
                                           class="w-16 h-10 text-center bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl text-[14px] font-bold focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15]">
                                </div>

                                {{-- Subtotal --}}
                                <div class="text-right shrink-0 w-28">
                                    <div class="font-extrabold text-gray-900 text-[15px]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                </div>

                                {{-- Remove --}}
                                <form action="{{ route('customer.cart.remove', $item['product']) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors" title="Remove">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <button type="submit" class="mt-2 px-6 py-2.5 bg-white border border-[#EBE1D7] hover:bg-gray-50 text-gray-700 rounded-xl text-[13px] font-bold transition-colors">
                            Update Cart
                        </button>
                    </form>
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm sticky top-24">
                        <h3 class="text-lg font-extrabold font-serif text-gray-900 mb-6">Order Summary</h3>

                        <div class="space-y-3 mb-6 border-b border-gray-100 pb-6">
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Items ({{ count($cartItems) }})</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-[16px] font-extrabold mb-8">
                            <span class="text-gray-900">Total</span>
                            <span class="text-[#8C4A15] font-serif text-xl">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('customer.checkout') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan (Opsional)</label>
                                <textarea name="notes" rows="2" placeholder="Misalnya: Tanpa es, extra gula..." class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] resize-none"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-[#8C4A15] hover:bg-[#723C10] text-white py-3.5 rounded-xl text-[14px] font-bold transition-colors shadow-md">
                                Place Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <h3 class="text-xl font-bold font-serif text-gray-900 mb-2">Your Cart is Empty</h3>
                <p class="text-gray-500 text-[14px] mb-6">Start exploring our menu and add your favorites!</p>
                <a href="{{ route('menu') }}" class="px-6 py-3 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold transition-colors inline-block">
                    Browse Menu
                </a>
            </div>
        @endif
    </div>
@endsection
