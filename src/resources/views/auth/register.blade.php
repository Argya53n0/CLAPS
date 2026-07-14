<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Daftar akun Claps Coffee.">
    <title>Register - Claps Coffee</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased min-h-screen relative flex items-center justify-center p-4 bg-claps-bg font-sans text-gray-800">

    {{-- Main Container --}}
    <div class="w-full max-w-[1000px] bg-white rounded-2xl shadow-xl overflow-hidden flex flex-col md:flex-row min-h-[650px]">
        
        {{-- Left Side: Image Banner --}}
        <div class="w-full md:w-1/2 relative hidden md:block">
            <img src="{{ asset('images/flat-white.png') }}" alt="Coffee" class="absolute inset-0 w-full h-full object-cover">
            
            {{-- Gradient Overlay --}}
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            
            {{-- Text Content --}}
            <div class="absolute bottom-10 left-10 right-10 text-white">
                <h2 class="text-3xl font-bold font-serif mb-2 tracking-wide text-white">Claps Coffee</h2>
                <p class="text-[15px] text-white/90 leading-relaxed font-medium">
                    Discover warmth in every cup. Join our<br>neighborhood today.
                </p>
            </div>
        </div>

        {{-- Right Side: Registration Form --}}
        <div class="w-full md:w-1/2 p-8 md:p-12 lg:p-16 flex flex-col justify-center bg-white">
            
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 font-serif tracking-tight">
                    Create an Account
                </h1>
                <p class="text-gray-500 text-[13px] mt-2 font-medium">
                    Fill in your details to get started.
                </p>
            </div>

            <form action="{{ route('register.post') }}" method="POST" class="space-y-4">
                @csrf
                
                {{-- Full Name --}}
                <div>
                    <label for="name" class="block text-[10px] font-bold tracking-widest text-gray-900 uppercase mb-2">
                        Full Name
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-[#A69385]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <input type="text" id="name" name="name" placeholder="Jane Doe" value="{{ old('name') }}"
                            class="w-full bg-[#FCF8F2] border border-[#EBE1D7] text-[13px] text-gray-800 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:border-claps-brown focus:ring-1 focus:ring-claps-brown placeholder-gray-400 transition-all">
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs font-medium mt-1.5 px-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Address --}}
                <div>
                    <label for="email" class="block text-[10px] font-bold tracking-widest text-gray-900 uppercase mb-2">
                        Email Address
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-[#A69385]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <input type="email" id="email" name="email" placeholder="jane@example.com" value="{{ old('email') }}"
                            class="w-full bg-[#FCF8F2] border border-[#EBE1D7] text-[13px] text-gray-800 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:border-claps-brown focus:ring-1 focus:ring-claps-brown placeholder-gray-400 transition-all">
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs font-medium mt-1.5 px-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-[10px] font-bold tracking-widest text-gray-900 uppercase mb-2">
                        Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-[#A69385]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input type="password" id="password" name="password" placeholder="••••••••" 
                            class="w-full bg-[#FCF8F2] border border-[#EBE1D7] text-[13px] text-gray-800 rounded-lg pl-10 pr-10 py-3 focus:outline-none focus:border-claps-brown focus:ring-1 focus:ring-claps-brown placeholder-gray-400 transition-all tracking-widest font-medium">
                        <button type="button" class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-[#A69385] hover:text-claps-brown transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-medium mt-1.5 px-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label for="password_confirmation" class="block text-[10px] font-bold tracking-widest text-gray-900 uppercase mb-2">
                        Confirm Password
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-[18px] w-[18px] text-[#A69385]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                                <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                            </svg>
                        </div>
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="••••••••" 
                            class="w-full bg-[#FCF8F2] border border-[#EBE1D7] text-[13px] text-gray-800 rounded-lg pl-10 pr-4 py-3 focus:outline-none focus:border-claps-brown focus:ring-1 focus:ring-claps-brown placeholder-gray-400 transition-all tracking-widest font-medium">
                    </div>
                </div>

                {{-- Terms and Conditions --}}
                <div class="flex flex-col gap-1 pt-2">
                    <div class="flex items-start gap-2">
                        <div class="flex items-center h-5 mt-0.5">
                            <input id="terms" name="terms" type="checkbox" value="1" class="w-3.5 h-3.5 border-[#EBE1D7] rounded text-claps-brown focus:ring-claps-brown accent-claps-brown">
                        </div>
                        <label for="terms" class="text-[12px] text-gray-500 leading-relaxed">
                            Saya setuju dengan <a href="#" class="font-semibold text-claps-brown hover:underline">Syarat & Ketentuan</a> serta <a href="#" class="font-bold text-claps-brown hover:underline">Kebijakan Privasi</a>.
                        </label>
                    </div>
                    @error('terms')
                        <p class="text-red-500 text-xs font-medium px-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="pt-5">
                    <button type="submit" class="w-full bg-[#8C4A15] hover:bg-[#723C10] text-white text-[14px] font-semibold rounded-full py-3 transition-all duration-300 shadow-md flex items-center justify-center gap-2 group">
                        Daftar 
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </button>
                </div>
            </form>

            {{-- Footer --}}
            <div class="mt-8 text-center">
                <p class="text-[13px] text-gray-500">
                    Sudah punya akun? 
                    <a href="/login" class="font-bold text-[#8C4A15] hover:underline transition-all ml-1">
                        Masuk
                    </a>
                </p>
            </div>

        </div>
    </div>

</body>

</html>
