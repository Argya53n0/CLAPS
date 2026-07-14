@extends('customer.layout')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-12 py-8 lg:py-12 flex flex-col lg:flex-row gap-8 items-start">
    
    {{-- Sidebar (Mobile: Horizontal Scroll, Desktop: Vertical List) --}}
    <aside class="w-full lg:w-[280px] shrink-0 sticky top-24">
        {{-- Profile Mini Header --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-[#EBE1D7] mb-6 flex items-center gap-4 hidden lg:flex">
            <div class="w-14 h-14 rounded-full bg-[#E8E1F5] flex items-center justify-center text-xl font-bold text-[#8b5cf6]">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <div>
                <h3 class="font-bold text-gray-900 leading-tight line-clamp-1">{{ auth()->user()->name }}</h3>
                <p class="text-[12px] text-gray-500 font-medium mt-0.5">Gold Member</p>
            </div>
        </div>

        {{-- Navigation Menu --}}
        <div class="bg-white rounded-2xl shadow-sm border border-[#EBE1D7] overflow-hidden overflow-x-auto lg:overflow-visible">
            <ul class="flex lg:flex-col min-w-max lg:min-w-0">
                @php
                    $menu = [
                        ['label' => 'Dashboard', 'route' => 'profile', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />'],
                        ['label' => 'Riwayat Pesanan', 'route' => 'customer.orders', 'icon' => '<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline>'],
                        ['label' => 'Buku Alamat', 'route' => 'customer.addresses.index', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />'],
                        ['label' => 'Edit Profil', 'route' => 'customer.profile.edit', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle>'],
                    ];
                @endphp

                @foreach($menu as $item)
                    <li class="border-b lg:border-b-0 border-[#F5E6D8] last:border-0 relative">
                        @php
                            $isActive = request()->routeIs($item['route'] . '*');
                        @endphp
                        @if($isActive)
                            <div class="absolute inset-y-0 left-0 w-1 bg-[#8C4A15] lg:block hidden"></div>
                            <div class="absolute inset-x-0 bottom-0 h-1 bg-[#8C4A15] lg:hidden block"></div>
                        @endif
                        <a href="{{ route($item['route']) }}" class="flex items-center gap-3 px-6 py-4 transition-colors {{ $isActive ? 'text-[#8C4A15] bg-[#FDF4EB]' : 'text-gray-600 hover:bg-gray-50' }}">
                            <svg class="w-5 h-5 shrink-0 {{ $isActive ? 'text-[#8C4A15]' : 'text-gray-400' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">{!! $item['icon'] !!}</svg>
                            <span class="font-semibold text-[13.5px] whitespace-nowrap">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
                
                {{-- Logout Button --}}
                <li class="border-t border-[#F5E6D8] relative lg:block">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full flex items-center gap-3 px-6 py-4 text-gray-500 hover:bg-red-50 hover:text-red-600 transition-colors">
                            <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                            <span class="font-semibold text-[13.5px] whitespace-nowrap">Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="w-full flex-grow min-w-0">
        @yield('account_content')
    </main>

</div>
@endsection
