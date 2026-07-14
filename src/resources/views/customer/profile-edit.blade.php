@extends('customer.layout')

@section('title', 'Edit Profil - Claps Coffee')

@section('content')
    <div class="max-w-2xl mx-auto px-6 lg:px-12 py-12">
        <div class="bg-white rounded-3xl border border-[#EBE1D7] p-8 shadow-sm">
            <h1 class="text-2xl font-extrabold font-serif text-gray-900 mb-6">Edit Profil</h1>

            <form action="{{ route('customer.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
                               class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[14px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15]">
                        @error('name') <span class="text-red-500 text-[12px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                               class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[14px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15]">
                        @error('email') <span class="text-red-500 text-[12px] mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-4 border-t border-gray-100 flex items-center justify-between">
                        <a href="{{ route('profile') }}" class="text-[14px] font-bold text-gray-500 hover:text-gray-700">Batal</a>
                        <button type="submit" class="px-6 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold shadow-md transition-colors">
                            Simpan Perubahan
                        </button>
                    </div>
                </div>
            </form>
        </div>
        
        <div class="mt-6 text-center">
             <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700 text-[14px] font-bold transition-colors">Logout dari Akun</button>
            </form>
        </div>
    </div>
@endsection
