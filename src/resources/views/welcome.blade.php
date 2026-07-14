<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Claps Coffee - Awali harimu dengan kehangatan dan aroma kopi terbaik.">
    <title>Claps Coffee</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased">

    {{-- ===== NAVBAR ===== --}}
    <header class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md shadow-sm">
        <nav class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            {{-- Logo --}}
            <a href="/" class="text-xl font-bold text-claps-brown font-serif tracking-wide">
                Claps Coffee
            </a>

            {{-- Nav Links --}}
            <ul class="hidden md:flex items-center gap-8 text-sm font-medium text-claps-text-gray">
                <li><a href="#" class="text-claps-brown border-b-2 border-claps-brown pb-1">Home</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Menu</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Locations</a></li>
            </ul>

            {{-- Auth Buttons --}}
            <div class="hidden md:flex items-center gap-4">
                <a href="/login" class="text-sm font-medium text-claps-text-dark hover:text-claps-brown transition-colors duration-200">Login</a>
                <a href="/register" class="text-sm font-medium text-white bg-claps-brown hover:bg-claps-brown-dark px-5 py-2 rounded-full transition-colors duration-200">Register</a>
            </div>

            {{-- Mobile Hamburger --}}
            <button id="mobile-menu-btn" class="md:hidden flex flex-col gap-1.5 p-2" aria-label="Toggle menu">
                <span class="w-6 h-0.5 bg-claps-text-dark rounded"></span>
                <span class="w-6 h-0.5 bg-claps-text-dark rounded"></span>
                <span class="w-6 h-0.5 bg-claps-text-dark rounded"></span>
            </button>
        </nav>

        {{-- Mobile Menu --}}
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t px-6 py-4">
            <ul class="flex flex-col gap-4 text-sm font-medium text-claps-text-gray">
                <li><a href="#" class="text-claps-brown">Home</a></li>
                <li><a href="#">Menu</a></li>
                <li><a href="#">Locations</a></li>
            </ul>
            <div class="flex flex-col gap-3 mt-8">
                <a href="/login" class="text-sm font-medium text-claps-text-dark">Login</a>
                <a href="/register" class="text-sm font-medium text-white bg-claps-brown px-5 py-2 rounded-full">Register</a>
            </div>
        </div>
    </header>


    {{-- ===== HERO SECTION ===== --}}
    <section class="relative w-full min-h-[85vh] flex items-end overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero.png') }}" alt="Barista membuat kopi" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-r from-black/60 via-black/30 to-transparent"></div>
        </div>

        {{-- Content --}}
        <div class="relative z-10 max-w-7xl mx-auto px-6 pb-20 pt-32 w-full">
            <p class="text-amber-300 text-sm font-semibold uppercase tracking-widest mb-3">Menyapa Pagi</p>
            <h1 class="text-4xl md:text-6xl font-bold text-white leading-tight max-w-lg">
                Selamat Pagi, Penikmat Kopi.
            </h1>
            <p class="text-white/80 mt-5 max-w-md text-base leading-relaxed">
                Awali harimu dengan kehangatan dan aroma kopi terbaik.
                Dirancang khusus untuk menemani setiap momen bahagiamu.
            </p>
            <div class="flex flex-wrap gap-4 mt-8">
                <a href="#" class="bg-claps-brown hover:bg-claps-brown-dark text-white font-semibold px-7 py-3 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl">
                    Pesan Sekarang
                </a>
                <a href="#" class="bg-white/10 backdrop-blur-sm border border-white/40 text-white font-semibold px-7 py-3 rounded-full hover:bg-white/20 transition-all duration-300">
                    Lihat Menu
                </a>
            </div>
        </div>
    </section>


    {{-- ===== PROMO SECTION ===== --}}
    <section class="max-w-7xl mx-auto px-6 py-20">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-end md:justify-between mb-10">
            <div>
                <h2 class="text-3xl md:text-4xl font-bold">Promo Spesial Musim Ini</h2>
                <p class="text-claps-text-gray mt-2">Kesegaran baru untuk hari yang cerah.</p>
            </div>
            <a href="#" class="text-claps-brown font-semibold text-sm mt-4 md:mt-0 hover:underline flex items-center gap-1">
                Lihat Semua Promo
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
            </a>
        </div>

        {{-- Promo Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Card 1: Citrus Cold Brew --}}
            <div class="bg-claps-card-promo rounded-2xl overflow-hidden flex flex-col sm:flex-row shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="sm:w-1/2 h-56 sm:h-auto">
                    <img src="{{ asset('images/promo1.png') }}" alt="Citrus Cold Brew" class="w-full h-full object-cover">
                </div>
                <div class="sm:w-1/2 p-6 flex flex-col justify-between">
                    <div>
                        <span class="inline-block bg-claps-brown text-white text-xs font-bold px-3 py-1 rounded-full mb-3">Baru</span>
                        <h3 class="text-xl font-bold">Citrus Cold Brew</h3>
                        <p class="text-claps-text-gray text-sm mt-2 leading-relaxed">
                            Perpaduan unik cold brew pilihan dengan kesegaran citrus. Cocok untuk cuaca panas.
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-claps-brown font-bold text-sm">Diskon 20%</span>
                        <button class="w-8 h-8 rounded-full border border-claps-text-gray/30 flex items-center justify-center text-claps-text-gray hover:bg-claps-brown hover:text-white hover:border-claps-brown transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Card 2: Kopi & Pastry --}}
            <div class="bg-claps-card-promo rounded-2xl overflow-hidden flex flex-col sm:flex-row shadow-sm hover:shadow-md transition-shadow duration-300">
                <div class="sm:w-1/2 h-56 sm:h-auto">
                    <img src="{{ asset('images/promo2.png') }}" alt="Kopi & Pastry" class="w-full h-full object-cover">
                </div>
                <div class="sm:w-1/2 p-6 flex flex-col justify-between">
                    <div>
                        <span class="inline-block bg-white border border-claps-brown text-claps-brown text-xs font-bold px-3 py-1 rounded-full mb-3">Paket Hemat</span>
                        <h3 class="text-xl font-bold">Kopi & Pastry</h3>
                        <p class="text-claps-text-gray text-sm mt-2 leading-relaxed">
                            Beli minuman apapun ukuran medium, dapatkan potongan 50% untuk semua jenis pastry.
                        </p>
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <span class="text-claps-brown font-bold text-sm">Mulai Rp 45.000</span>
                        <button class="w-8 h-8 rounded-full border border-claps-text-gray/30 flex items-center justify-center text-claps-text-gray hover:bg-claps-brown hover:text-white hover:border-claps-brown transition-all duration-200">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ===== REKOMENDASI SECTION ===== --}}
    <section class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-6">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold">Rekomendasi Hari Ini</h2>
                <p class="text-claps-text-gray mt-2">Pilihan favorit para barista untuk menemani aktivitasmu.</p>
            </div>

            {{-- Product Grid --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                {{-- Product 1 --}}
                <div class="bg-claps-bg rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('images/caramel-macchiato.png') }}" alt="Caramel Macchiato" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-base">Caramel Macchiato</h3>
                        <p class="text-claps-text-gray text-xs mt-1 leading-relaxed">Espresso, steamed milk, dan saus karamel manis.</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="font-bold text-sm text-claps-text-dark">Rp 38.000</span>
                            <button class="w-7 h-7 rounded-full bg-claps-brown/10 flex items-center justify-center text-claps-brown hover:bg-claps-brown hover:text-white transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Product 2 --}}
                <div class="bg-claps-bg rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('images/butter-croissant.png') }}" alt="Butter Croissant" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-base">Butter Croissant</h3>
                        <p class="text-claps-text-gray text-xs mt-1 leading-relaxed">Renyah di luar, lembut di dalam dengan butter premium.</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="font-bold text-sm text-claps-text-dark">Rp 25.000</span>
                            <button class="w-7 h-7 rounded-full bg-claps-brown/10 flex items-center justify-center text-claps-brown hover:bg-claps-brown hover:text-white transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Product 3 --}}
                <div class="bg-claps-bg rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('images/flat-white.png') }}" alt="Flat White" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-base">Flat White</h3>
                        <p class="text-claps-text-gray text-xs mt-1 leading-relaxed">Double ristretto dengan microfoam milk yang lembut.</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="font-bold text-sm text-claps-text-dark">Rp 35.000</span>
                            <button class="w-7 h-7 rounded-full bg-claps-brown/10 flex items-center justify-center text-claps-brown hover:bg-claps-brown hover:text-white transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Product 4 --}}
                <div class="bg-claps-bg rounded-2xl overflow-hidden shadow-sm hover:shadow-md transition-all duration-300 hover:-translate-y-1">
                    <div class="h-44 overflow-hidden">
                        <img src="{{ asset('images/banana-bread.png') }}" alt="Banana Bread" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                    </div>
                    <div class="p-4">
                        <h3 class="font-bold text-base">Banana Bread</h3>
                        <p class="text-claps-text-gray text-xs mt-1 leading-relaxed">Manis alami pisang dengan taburan walnut renyah.</p>
                        <div class="flex items-center justify-between mt-3">
                            <span class="font-bold text-sm text-claps-text-dark">Rp 22.000</span>
                            <button class="w-7 h-7 rounded-full bg-claps-brown/10 flex items-center justify-center text-claps-brown hover:bg-claps-brown hover:text-white transition-all duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ===== FOOTER ===== --}}
    <footer class="bg-claps-bg border-t border-claps-text-gray/10 py-10">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row md:items-center md:justify-between gap-6">
            <div>
                <h4 class="text-lg font-bold text-claps-text-dark font-serif">Claps Coffee</h4>
                <p class="text-claps-text-gray text-sm mt-1">&copy; 2024 Claps Coffee Roasters. Handcrafted with warmth.</p>
            </div>
            <ul class="flex flex-wrap gap-6 text-sm text-claps-text-gray">
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">About Us</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Sustainability</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Shipping Policy</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Contact</a></li>
                <li><a href="#" class="hover:text-claps-brown transition-colors duration-200">Careers</a></li>
            </ul>
        </div>
    </footer>

    {{-- Mobile Menu Toggle Script --}}
    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function () {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>
