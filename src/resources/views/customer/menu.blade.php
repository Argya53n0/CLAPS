@extends('customer.layout')

@section('title', 'Menu - Claps Coffee')

@section('content')
    {{-- Hero Section with Glassmorphism --}}
    <div class="relative w-full bg-[#1A1A1A] overflow-hidden">
        {{-- Background Effects --}}
        <div class="absolute inset-0 opacity-40 mix-blend-overlay" style="background-image: url('https://images.unsplash.com/photo-1497935586351-b67a49e012bf?q=80&w=2575&auto=format&fit=crop'); background-size: cover; background-position: center;"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-[#1A1A1A] via-[#1A1A1A]/50 to-transparent"></div>
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-[#8C4A15] rounded-full mix-blend-screen filter blur-[100px] opacity-70 animate-pulse"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-[#C46A4F] rounded-full mix-blend-screen filter blur-[100px] opacity-50"></div>

        <div class="relative max-w-6xl mx-auto px-6 lg:px-12 pt-24 pb-32 flex flex-col items-center text-center">
            <span class="px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white/90 text-[11px] font-black tracking-[0.2em] uppercase mb-8 shadow-xl">Handcrafted Perfection</span>
            <h1 class="text-5xl md:text-7xl font-extrabold font-serif text-white tracking-tight mb-6 drop-shadow-lg leading-tight">
                Discover Our <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#D4A373] to-[#FAEDCD]">Menu</span>
            </h1>
            <p class="text-white/80 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed mb-12">
                Sip into something extraordinary. Every bean is ethically sourced, roasted to perfection, and brewed with passion.
            </p>

            {{-- Search Bar with Glassmorphism --}}
            <form action="{{ route('menu') }}" method="GET" class="w-full max-w-xl relative group z-10">
                <input type="hidden" name="category" value="{{ $currentCategory }}">
                <div class="absolute inset-y-0 left-0 pl-6 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-white/60 group-focus-within:text-white transition-colors" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search your favorite coffee..." 
                       class="w-full pl-14 pr-32 py-5 bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl text-white placeholder:text-white/60 focus:outline-none focus:ring-2 focus:ring-[#D4A373] focus:bg-white/20 transition-all text-[15px] font-medium shadow-[0_8px_32px_0_rgba(0,0,0,0.37)]">
                <button type="submit" class="absolute inset-y-2.5 right-2.5 px-6 bg-gradient-to-r from-[#8C4A15] to-[#723C10] hover:from-[#723C10] hover:to-[#5c300d] text-white rounded-xl text-[14px] font-bold transition-all shadow-lg flex items-center justify-center">
                    Search
                </button>
            </form>
        </div>
    </div>

    {{-- Main Content Area --}}
    <div class="max-w-6xl mx-auto px-6 lg:px-12 py-16 -mt-14 relative z-20">
        
        {{-- Category Tabs --}}
        <div class="bg-white/90 backdrop-blur-2xl border border-[#EBE1D7] p-2 rounded-2xl shadow-xl flex items-center justify-start md:justify-center gap-2 mb-16 overflow-x-auto hide-scrollbar snap-x">
            @php
                $categories = [
                    'all' => 'All Items',
                    'coffee' => 'Coffee',
                    'non_coffee' => 'Non-Coffee',
                    'snack' => 'Snacks',
                    'food' => 'Food',
                ];
            @endphp
            @foreach($categories as $value => $label)
                <a href="{{ route('menu', ['category' => $value, 'search' => request('search')]) }}"
                   class="snap-center px-6 py-3.5 rounded-xl text-[14px] font-bold transition-all whitespace-nowrap flex items-center gap-2.5
                   {{ $currentCategory === $value 
                        ? 'bg-[#8C4A15] text-white shadow-[0_8px_20px_-6px_rgba(140,74,21,0.6)] scale-[1.02]' 
                        : 'text-gray-500 hover:bg-[#FDF4EB] hover:text-[#8C4A15]' }}">
                    <span class="flex items-center justify-center">
                        @if($value === 'all')
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/></svg>
                        @elseif($value === 'coffee')
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="9" x2="9" y1="2" y2="4"/><line x1="15" x2="15" y1="2" y2="4"/></svg>
                        @elseif($value === 'non_coffee')
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m6 8 1.75 12.25A2 2 0 0 0 9.71 22h4.58a2 2 0 0 0 1.96-1.75L18 8"/><path d="M5 8h14"/><path d="M7 5a3 3 0 0 1 3-3h4a3 3 0 0 1 3 3v3H7V5Z"/><path d="m12 2-3 8"/></svg>
                        @elseif($value === 'snack')
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2a10 10 0 1 0 10 10 4 4 0 0 1-5-5 4 4 0 0 1-5-5"/><path d="M8.5 8.5v.01"/><path d="M16 15.5v.01"/><path d="M12 12v.01"/><path d="M11 17v.01"/><path d="M7 14v.01"/></svg>
                        @elseif($value === 'food')
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 2v7c0 1.1.9 2 2 2h4a2 2 0 0 0 2-2V2"/><path d="M7 2v20"/><path d="M21 15V2v0a5 5 0 0 0-5 5v6c0 1.1.9 2 2 2h3Zm0 0v7"/></svg>
                        @endif
                    </span>
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Product Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($products as $product)
                <div class="bg-white rounded-[2rem] border border-[#EBE1D7]/60 overflow-hidden shadow-sm hover:shadow-[0_24px_48px_-12px_rgba(140,74,21,0.15)] hover:-translate-y-2 transition-all duration-500 group flex flex-col relative">
                    
                    {{-- Image Container --}}
                    <div class="aspect-[4/3] bg-gradient-to-br from-[#FDF4EB] to-[#F5F2F0] relative overflow-hidden p-6 flex items-center justify-center">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-2xl group-hover:scale-110 group-hover:rotate-2 transition-transform duration-700 ease-out shadow-md">
                        @else
                            <div class="w-full h-full rounded-2xl bg-white/50 backdrop-blur-sm border border-white flex items-center justify-center shadow-inner group-hover:scale-105 transition-transform duration-500">
                                <svg class="w-16 h-16 text-[#8C4A15]/20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/><line x1="9" y1="2" x2="9" y2="4"/><line x1="15" y1="2" x2="15" y2="4"/></svg>
                            </div>
                        @endif
                        
                        {{-- Floating Badges --}}
                        <div class="absolute top-5 left-5 flex flex-col gap-2">
                            @php
                                $catStyle = [
                                    'coffee' => 'bg-[#8C4A15]/95 text-white',
                                    'non_coffee' => 'bg-[#138A49]/95 text-white',
                                    'snack' => 'bg-[#C46A4F]/95 text-white',
                                    'food' => 'bg-[#5B7553]/95 text-white',
                                ];
                                $catLabel = ['coffee' => 'Coffee', 'non_coffee' => 'Non-Coffee', 'snack' => 'Snack', 'food' => 'Food'];
                            @endphp
                            <span class="px-4 py-1.5 rounded-full text-[10px] font-black tracking-widest uppercase {{ $catStyle[$product->category] ?? 'bg-gray-800/95 text-white' }} shadow-lg backdrop-blur-md">
                                {{ $catLabel[$product->category] ?? ucfirst($product->category) }}
                            </span>
                        </div>
                    </div>

                    {{-- Card Content --}}
                    <div class="p-6 flex flex-col flex-grow bg-white">
                        <div class="flex-grow">
                            <h3 class="text-lg font-bold font-serif text-gray-900 leading-tight group-hover:text-[#8C4A15] transition-colors mb-2">{{ $product->name }}</h3>
                            <p class="text-[13px] text-gray-500 leading-relaxed line-clamp-2 mb-6">{{ $product->description ?: 'A delicious handcrafted item made with love and premium ingredients.' }}</p>
                        </div>
                        
                        {{-- Action Area --}}
                        <div class="pt-4 border-t border-gray-100 flex items-center justify-between mt-auto">
                            <span class="text-lg font-extrabold text-gray-900">{{ $product->formatted_price }}</span>
                            @auth
                                <button type="button" onclick="openVariantModal({{ $product->id }}, '{{ addslashes($product->name) }}', {{ $product->price }}, '{{ $product->category }}')" class="w-10 h-10 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-full flex items-center justify-center transition-all duration-300 shadow-md hover:shadow-lg group/btn" title="Tambah ke Keranjang">
                                    <svg class="w-5 h-5 group-hover/btn:scale-110 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="text-[12px] font-bold text-[#8C4A15] hover:underline">
                                    Login to Order
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-28 px-6 flex flex-col items-center justify-center bg-white/50 backdrop-blur-md rounded-[2.5rem] border border-dashed border-[#EBE1D7]">
                    <div class="w-24 h-24 bg-[#FDF4EB] rounded-full flex items-center justify-center mb-6 shadow-inner">
                        <svg class="w-12 h-12 text-[#8C4A15]/40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.3-4.3"/></svg>
                    </div>
                    <h3 class="text-2xl font-bold font-serif text-gray-900 mb-3">No Items Found</h3>
                    <p class="text-gray-500 text-[15px] font-medium text-center max-w-md">We couldn't find any products matching your current category or search. Try adjusting your filters.</p>
                    <a href="{{ route('menu') }}" class="mt-8 px-8 py-3.5 bg-[#8C4A15] text-white rounded-xl font-bold text-[14px] hover:bg-[#723C10] hover:shadow-[0_8px_20px_-6px_rgba(140,74,21,0.5)] transition-all">Clear Filters</a>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($products->hasPages())
            <div class="mt-16 flex justify-center">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>

    {{-- Variant Selection Modal --}}
    @auth
    <div id="variantModal" class="fixed inset-0 z-[100] hidden">
        <div class="absolute inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity" onclick="closeVariantModal()"></div>
        <div class="fixed inset-0 flex items-center justify-center p-4">
            <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden transform scale-95 opacity-0 transition-all" id="variantModalContent">
                <form id="addToCartForm" method="POST" action="">
                    @csrf
                    <div class="p-6 border-b border-gray-100 flex justify-between items-start">
                        <div>
                            <h3 id="modalProductName" class="text-xl font-bold font-serif text-gray-900 mb-1">Product Name</h3>
                            <p id="modalProductPrice" class="text-[14px] text-gray-500 font-bold">Rp 0</p>
                        </div>
                        <button type="button" onclick="closeVariantModal()" class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-200 transition-colors">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                    </div>

                    <div class="p-6 space-y-6" id="variantOptionsContainer">
                        {{-- Generic Options for Coffee/Drinks --}}
                        <div class="variant-group drink-only">
                            <label class="block text-[13px] font-bold text-gray-700 mb-3">Suhu</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[temperature]" value="Ice" class="peer sr-only" checked>
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Ice</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[temperature]" value="Hot" class="peer sr-only">
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Hot</div>
                                </label>
                            </div>
                        </div>

                        <div class="variant-group drink-only">
                            <label class="block text-[13px] font-bold text-gray-700 mb-3">Tingkat Manis</label>
                            <div class="grid grid-cols-3 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[sugar]" value="Normal" class="peer sr-only" checked>
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Normal</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[sugar]" value="Less" class="peer sr-only">
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Less Sugar</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[sugar]" value="No Sugar" class="peer sr-only">
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">No Sugar</div>
                                </label>
                            </div>
                        </div>

                        <div class="variant-group coffee-only">
                            <label class="block text-[13px] font-bold text-gray-700 mb-3">Extra Shot (+Rp 5.000)</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[extra_shot]" value="No" class="peer sr-only" checked>
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Tidak</div>
                                </label>
                                <label class="cursor-pointer">
                                    <input type="radio" name="options[extra_shot]" value="Yes" class="peer sr-only">
                                    <div class="px-4 py-2.5 rounded-xl border border-gray-200 text-center text-[13px] font-bold text-gray-600 peer-checked:border-[#8C4A15] peer-checked:bg-[#FCF8F2] peer-checked:text-[#8C4A15] transition-all">Ya, Extra Shot</div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="p-6 bg-gray-50 border-t border-gray-100">
                        <button type="submit" class="w-full py-3.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold transition-all shadow-md flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 5v14M5 12h14"/></svg>
                            Tambahkan ke Keranjang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        const modal = document.getElementById('variantModal');
        const modalContent = document.getElementById('variantModalContent');
        const form = document.getElementById('addToCartForm');
        
        function openVariantModal(productId, productName, price, category) {
            // Update details
            document.getElementById('modalProductName').textContent = productName;
            document.getElementById('modalProductPrice').textContent = 'Rp ' + price.toLocaleString('id-ID');
            form.action = `/customer/cart/add/${productId}`;

            // Show/hide variant options based on category
            const drinkGroups = document.querySelectorAll('.drink-only');
            const coffeeGroups = document.querySelectorAll('.coffee-only');
            
            drinkGroups.forEach(el => el.style.display = (category === 'coffee' || category === 'non_coffee') ? 'block' : 'none');
            coffeeGroups.forEach(el => el.style.display = (category === 'coffee') ? 'block' : 'none');

            // Show modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modalContent.classList.remove('scale-95', 'opacity-0');
                modalContent.classList.add('scale-100', 'opacity-100');
            }, 10);
        }

        function closeVariantModal() {
            modalContent.classList.remove('scale-100', 'opacity-100');
            modalContent.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
    @endpush
    @endauth
@endsection
