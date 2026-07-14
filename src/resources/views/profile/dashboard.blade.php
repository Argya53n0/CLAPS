@extends('customer.layout')

@section('title', 'Dashboard - Claps Coffee')

@section('content')
    <div class="w-full max-w-6xl mx-auto px-6 lg:px-12 py-12">
        
        {{-- Profile Header --}}
        <section class="flex flex-col md:flex-row gap-6 items-start md:items-center mb-12">
            {{-- Avatar --}}
            <div class="relative shrink-0">
                <div class="w-[120px] h-[120px] rounded-2xl bg-[#E8E1F5] flex items-center justify-center shadow-sm text-4xl font-bold text-[#8b5cf6]">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                {{-- Verified Badge --}}
                <div class="absolute -bottom-2 -right-2 bg-[#8C4A15] text-white p-1.5 rounded-full border-4 border-[#FCF8F2] shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                    </svg>
                </div>
            </div>

            {{-- Name & Status --}}
            <div class="flex-grow">
                <h1 class="text-[38px] font-bold font-serif text-gray-900 leading-tight mb-2">{{ auth()->user()->name }}</h1>
                <div class="flex flex-wrap gap-3 items-center">
                    <span class="bg-[#FDF4EB] text-[#8C4A15] border border-[#EBE1D7] px-3 py-1 rounded-full text-[10px] font-bold tracking-widest uppercase flex items-center gap-1.5 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        GOLD MEMBER
                    </span>
                    <span class="text-gray-500 text-[13px] font-medium">Member since {{ auth()->user()->created_at->format('Y') }}</span>
                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="flex gap-3 mt-4 md:mt-0">
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-6 py-2.5 rounded-full border border-[#D4C5B9] text-gray-700 text-[14px] font-semibold hover:bg-white hover:text-red-600 hover:border-red-600 transition-colors shadow-sm bg-transparent">
                        Logout
                    </button>
                </form>
                <a href="{{ route('menu') }}" class="px-6 py-2.5 rounded-full bg-[#8C4A15] hover:bg-[#723C10] text-white text-[14px] font-semibold transition-colors shadow-sm">
                    Order Now
                </a>
            </div>
        </section>


        {{-- Dashboard Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16">
            
            {{-- Loyalty Rewards Card (Left) --}}
            <div class="lg:col-span-7 bg-[#FDF4EB] rounded-[24px] p-8 relative overflow-hidden shadow-sm border border-[#F5E6D8]">
                <div class="flex justify-between items-start mb-8">
                    <div>
                        <h2 class="text-xl font-bold font-serif text-gray-900 mb-1">Loyalty Rewards</h2>
                        <p class="text-gray-600 text-[13px]">You're doing great! Almost at Diamond Tier.</p>
                    </div>
                    <div class="text-right">
                        <div class="text-3xl font-bold font-serif text-[#8C4A15]">1,250</div>
                        <div class="text-[10px] font-bold tracking-widest text-[#8C4A15] uppercase mt-1">Points Balance</div>
                    </div>
                </div>

                {{-- Progress Bar --}}
                <div class="mb-8">
                    <div class="flex justify-between text-[13px] font-medium text-gray-700 mb-2">
                        <span>Progress to Diamond</span>
                        <span>750 points left</span>
                    </div>
                    <div class="w-full bg-[#EBE1D7] rounded-full h-3 mb-2">
                        <div class="bg-[#8C4A15] h-3 rounded-full" style="width: 62.5%"></div>
                    </div>
                    <div class="flex justify-between text-[12px] text-gray-500">
                        <span>Gold (1,000 pts)</span>
                        <span>Diamond (2,000 pts)</span>
                    </div>
                </div>

                {{-- Reward Options --}}
                <div class="grid grid-cols-3 gap-4">
                    <div class="bg-[#F5E6D8]/60 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-[#EBE1D7]/50 hover:bg-[#F5E6D8] transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#8C4A15] mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 8h1a4 4 0 1 1 0 8h-1"></path><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path><line x1="6" y1="2" x2="6" y2="4"></line><line x1="10" y1="2" x2="10" y2="4"></line><line x1="14" y1="2" x2="14" y2="4"></line></svg>
                        <div class="text-[13px] font-semibold text-gray-800">Free Coffee</div>
                        <div class="text-[10px] text-gray-500 mt-1">500 pts</div>
                    </div>
                    <div class="bg-[#F5E6D8]/60 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-[#EBE1D7]/50 hover:bg-[#F5E6D8] transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#8C4A15] mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2.5a2.5 2.5 0 0 1 5 0v3a2.5 2.5 0 0 1-5 0v-3Z"></path><path d="M7 2.5a2.5 2.5 0 0 1 5 0v3a2.5 2.5 0 0 1-5 0v-3Z"></path><path d="M12 10a5 5 0 0 1 10 0v11H2V10a5 5 0 0 1 10 0Z"></path></svg>
                        <div class="text-[13px] font-semibold text-gray-800">Free Pastry</div>
                        <div class="text-[10px] text-gray-500 mt-1">800 pts</div>
                    </div>
                    <div class="bg-white/60 rounded-xl p-4 flex flex-col items-center justify-center text-center border border-[#EBE1D7] hover:bg-white transition cursor-pointer opacity-70">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#A69385] mb-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                        <div class="text-[13px] font-semibold text-gray-500">Beans Bag</div>
                        <div class="text-[10px] text-gray-400 mt-1">2,500 pts</div>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Grid (Right) --}}
            <div class="lg:col-span-5 grid grid-cols-2 gap-4">
                <a href="{{ route('customer.orders') }}" class="block bg-white rounded-[24px] p-6 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-md transition cursor-pointer border border-white/50 aspect-square">
                    <div class="w-12 h-12 rounded-full bg-[#FDF4EB] text-[#8C4A15] flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-800">Riwayat<br>Pesanan</h3>
                </a>
                
                <a href="{{ route('customer.cart') }}" class="block bg-white rounded-[24px] p-6 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-md transition cursor-pointer border border-white/50 aspect-square">
                    <div class="w-12 h-12 rounded-full bg-[#FDF4EB] text-[#8C4A15] flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-800">Keranjang<br>Belanja</h3>
                </a>

                <a href="{{ route('customer.profile.edit') }}" class="block bg-white rounded-[24px] p-6 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-md transition cursor-pointer border border-white/50 aspect-square">
                    <div class="w-12 h-12 rounded-full bg-[#FDF4EB] text-[#8C4A15] flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-800">Edit<br>Profil</h3>
                </a>

                <div class="bg-white rounded-[24px] p-6 flex flex-col items-center justify-center text-center shadow-sm hover:shadow-md transition cursor-pointer border border-white/50 aspect-square">
                    <div class="w-12 h-12 rounded-full bg-[#FDF4EB] text-[#8C4A15] flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect><line x1="3" y1="10" x2="21" y2="10"></line><path d="M8 10v4"></path><path d="M16 10v4"></path><path d="M12 10v4"></path></svg>
                    </div>
                    <h3 class="text-[14px] font-semibold text-gray-800">Voucher<br>Saya</h3>
                </div>
            </div>
        </div>

        {{-- Recent Orders Section --}}
        <div>
            <div class="flex justify-between items-end mb-6">
                <h2 class="text-2xl font-bold font-serif text-gray-900">Recent Orders</h2>
                <a href="{{ route('customer.orders') }}" class="text-[13px] font-semibold text-[#8C4A15] hover:underline">View All Orders</a>
            </div>

            @if($recentOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($recentOrders as $order)
                        <div class="bg-white rounded-2xl p-4 md:p-5 flex flex-col md:flex-row items-start md:items-center justify-between shadow-sm border border-white/50 gap-4">
                            <div class="flex items-center gap-4 w-full md:w-auto">
                                <div class="w-16 h-16 rounded-xl bg-[#E8E1F5] shrink-0 flex items-center justify-center overflow-hidden">
                                    @if($order->items->first() && $order->items->first()->product->image)
                                        <img src="{{ $order->items->first()->product->image }}" alt="Coffee" class="w-full h-full object-cover">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-[#8b5cf6]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                    @endif
                                </div>
                                <div>
                                    <div class="text-[13px] text-gray-500 mb-0.5">{{ $order->order_code }} • {{ $order->created_at->diffForHumans() }}</div>
                                    <h4 class="text-[15px] font-bold text-gray-900 line-clamp-1">
                                        {{ $order->items->map(fn($item) => $item->product ? $item->product->name : 'Item')->implode(', ') }}
                                    </h4>
                                    <div class="text-[13px] text-gray-500 mt-0.5">{{ $order->items->count() }} items</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between w-full md:w-auto gap-6 md:gap-8 border-t border-gray-100 md:border-none pt-4 md:pt-0">
                                <div class="text-left md:text-right">
                                    <div class="text-[18px] font-bold text-gray-900 font-serif mb-1">{{ $order->formatted_total }}</div>
                                    @php
                                        $statusStyles = [
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'preparing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                            'delivery' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'completed' => 'bg-green-100 text-green-800 border-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                                        ];
                                    @endphp
                                    <span class="inline-block text-[11px] font-bold px-2.5 py-0.5 rounded-full {{ $statusStyles[$order->status] ?? 'bg-gray-100' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                                <a href="{{ route('customer.orders.show', $order) }}" class="bg-[#FDF4EB] hover:bg-[#F5E6D8] text-[#8C4A15] px-5 py-2 rounded-full text-[13px] font-semibold transition-colors">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-8 text-center border border-gray-100 shadow-sm">
                    <p class="text-gray-500 text-[14px]">Kamu belum memiliki pesanan.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
