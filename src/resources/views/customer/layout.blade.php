<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Claps Coffee - Premium handcrafted coffee.">
    <title>@yield('title', 'Claps Coffee')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="antialiased min-h-screen bg-[#FCF8F2] font-sans text-gray-800 flex flex-col">

    {{-- Navbar --}}
    <nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-lg border-b border-[#EBE1D7]">
        <div class="max-w-6xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
            <a href="/" class="text-xl font-bold font-serif text-[#8C4A15] tracking-tight">Claps Coffee</a>

            <div class="hidden md:flex items-center gap-8 text-[14px] font-medium text-gray-600">
                <a href="/" class="hover:text-[#8C4A15] transition-colors">Home</a>
                <a href="{{ route('menu') }}" class="hover:text-[#8C4A15] transition-colors {{ request()->routeIs('menu') ? 'text-[#8C4A15] font-semibold' : '' }}">Menu</a>
                @auth
                    <a href="{{ route('customer.orders') }}" class="hover:text-[#8C4A15] transition-colors {{ request()->routeIs('customer.orders*') ? 'text-[#8C4A15] font-semibold' : '' }}">My Orders</a>
                @endauth
            </div>

            <div class="flex items-center gap-4">
                @auth
                    {{-- Cart Button --}}
                    <a href="{{ route('customer.cart') }}" class="relative p-2 text-gray-600 hover:text-[#8C4A15] transition-colors">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                        @php $cartCount = count(session('cart', [])); @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-1 -right-1 bg-[#8C4A15] text-white text-[10px] font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                        @endif
                    </a>

                    {{-- Profile Dropdown --}}
                    <div class="flex items-center gap-3">
                        <a href="{{ route('profile') }}" class="w-8 h-8 rounded-full bg-[#8C4A15] text-white flex items-center justify-center font-bold text-[12px]">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </a>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="px-5 py-2 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-lg text-[13px] font-semibold transition-colors">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    {{-- Flash Messages --}}
    @if(session('success'))
        <div class="max-w-6xl mx-auto px-6 lg:px-12 mt-4">
            <div class="bg-[#D1F4E0] text-[#138A49] border border-[#A8E6C1] px-5 py-3 rounded-xl text-[14px] font-medium flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-6xl mx-auto px-6 lg:px-12 mt-4">
            <div class="bg-red-50 text-red-700 border border-red-200 px-5 py-3 rounded-xl text-[14px] font-medium flex items-center gap-2">
                <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                {{ session('error') }}
            </div>
        </div>
    @endif

    {{-- Main Content --}}
    <main class="flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-[#FDF4EB] mt-auto w-full pt-12 pb-16 border-t border-[#EBE1D7]">
        <div class="max-w-6xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row md:items-center justify-between gap-8">
            <div>
                <h4 class="text-xl font-bold text-[#8C4A15] font-serif mb-2">Claps Coffee</h4>
                <p class="text-gray-600 text-[13px] leading-relaxed">
                    &copy; {{ date('Y') }} Claps Coffee Roasters.<br>Handcrafted with warmth.
                </p>
            </div>
            <ul class="flex flex-wrap gap-x-6 gap-y-3 text-[14px] text-gray-600 font-medium">
                <li><a href="/" class="hover:text-[#8C4A15] transition-colors">Home</a></li>
                <li><a href="{{ route('menu') }}" class="hover:text-[#8C4A15] transition-colors">Menu</a></li>
                <li><a href="#" class="hover:text-[#8C4A15] transition-colors">About Us</a></li>
                <li><a href="#" class="hover:text-[#8C4A15] transition-colors">Contact</a></li>
            </ul>
        </div>
    </footer>

    @stack('scripts')
</body>
</html>
