<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Admin - Claps Coffee.">
    <title>@yield('title', 'Admin') - Claps Coffee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased h-screen bg-[#FCF8F2] font-sans text-gray-800 flex overflow-hidden">

    {{-- Sidebar --}}
    <aside id="admin-sidebar" class="w-64 bg-white border-r border-[#EBE1D7] flex flex-col shadow-sm shrink-0 transition-all duration-300 overflow-hidden relative">
        <div class="h-20 flex items-center px-8 border-b border-[#EBE1D7] shrink-0 whitespace-nowrap">
            <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold font-serif text-[#8C4A15] tracking-tight flex items-center justify-center w-full">
                <span id="logo-text">Claps Admin</span>
                <span id="logo-icon" style="display: none;">C</span>
            </a>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto whitespace-nowrap">
            @php $current = Route::currentRouteName(); @endphp

            @if(auth()->user()->role === 'owner')
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ $current === 'admin.dashboard' ? 'bg-[#FDF4EB] text-[#8C4A15] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#8C4A15] font-medium' }}" title="Overview">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"></rect>
                    <rect x="14" y="3" width="7" height="7"></rect>
                    <rect x="14" y="14" width="7" height="7"></rect>
                    <rect x="3" y="14" width="7" height="7"></rect>
                </svg>
                <span class="sidebar-text transition-opacity duration-300">Overview</span>
            </a>
            @endif
            <a href="{{ route('admin.orders') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ $current === 'admin.orders' ? 'bg-[#FDF4EB] text-[#8C4A15] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#8C4A15] font-medium' }}" title="Orders">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <span class="sidebar-text transition-opacity duration-300">Orders</span>
            </a>
            <a href="{{ route('admin.menu') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ $current === 'admin.menu' ? 'bg-[#FDF4EB] text-[#8C4A15] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#8C4A15] font-medium' }}" title="Menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 8h1a4 4 0 1 1 0 8h-1"></path>
                    <path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"></path>
                    <line x1="6" y1="2" x2="6" y2="4"></line>
                    <line x1="10" y1="2" x2="10" y2="4"></line>
                    <line x1="14" y1="2" x2="14" y2="4"></line>
                </svg>
                <span class="sidebar-text transition-opacity duration-300">Menu</span>
            </a>
            @if(auth()->user()->role === 'owner')
            <a href="{{ route('admin.customers') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ $current === 'admin.customers' ? 'bg-[#FDF4EB] text-[#8C4A15] font-semibold' : 'text-gray-600 hover:bg-gray-50 hover:text-[#8C4A15] font-medium' }}" title="Customers">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
                <span class="sidebar-text transition-opacity duration-300">Customers</span>
            </a>
            @endif
        </nav>

        <div class="p-4 border-t border-[#EBE1D7] flex flex-col gap-1 shrink-0 whitespace-nowrap">
            <a href="/" target="_blank" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-gray-600 hover:bg-[#FCF8F2] hover:text-[#8C4A15] transition-all font-semibold" title="View Website">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"></path>
                    <polyline points="15 3 21 3 21 9"></polyline>
                    <line x1="10" y1="14" x2="21" y2="3"></line>
                </svg>
                <span class="sidebar-text transition-opacity duration-300">View Website</span>
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 rounded-xl text-red-600 hover:bg-red-50 transition-all font-semibold" title="Logout">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span class="sidebar-text transition-opacity duration-300">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <main class="flex-1 flex flex-col h-screen overflow-hidden">
        <header class="h-20 bg-white/50 backdrop-blur-md border-b border-[#EBE1D7] flex items-center justify-between px-4 md:px-8 shrink-0">
            <div class="flex items-center gap-4">
                <button id="sidebar-toggle" class="p-2 rounded-xl text-gray-500 hover:bg-gray-100 hover:text-gray-900 transition-colors">
                    <svg id="sidebar-icon" class="w-6 h-6 transition-transform duration-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <h2 class="text-2xl font-bold font-serif text-gray-900">
                    @yield('header', 'Dashboard')
                </h2>
            </div>
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-full bg-[#8C4A15] text-white flex items-center justify-center font-bold font-serif shadow-sm">
                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8">
            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="mb-6 bg-[#D1F4E0] text-[#138A49] border border-[#A8E6C1] px-5 py-3 rounded-xl text-[14px] font-medium flex items-center gap-2">
                    <svg class="w-5 h-5 shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toggleBtn = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('admin-sidebar');
            const icon = document.getElementById('sidebar-icon');
            const texts = document.querySelectorAll('.sidebar-text');
            const logoText = document.getElementById('logo-text');
            const logoIcon = document.getElementById('logo-icon');

            let isCollapsed = localStorage.getItem('sidebar_collapsed') === 'true';

            function updateSidebar() {
                if (isCollapsed) {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-20');
                    
                    texts.forEach(t => t.style.display = 'none');
                    if (logoText) logoText.style.display = 'none';
                    if (logoIcon) logoIcon.style.display = 'block';

                    icon.style.transform = 'rotate(180deg)';
                } else {
                    sidebar.classList.remove('w-20');
                    sidebar.classList.add('w-64');

                    texts.forEach(t => t.style.display = 'inline-block');
                    if (logoText) logoText.style.display = 'inline-block';
                    if (logoIcon) logoIcon.style.display = 'none';

                    icon.style.transform = 'rotate(0deg)';
                }
            }

            // Init
            updateSidebar();

            toggleBtn.addEventListener('click', () => {
                isCollapsed = !isCollapsed;
                localStorage.setItem('sidebar_collapsed', isCollapsed);
                updateSidebar();
            });
        });
    </script>
</body>
</html>
