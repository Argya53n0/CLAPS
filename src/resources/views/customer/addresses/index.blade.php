@extends('customer.account-layout')

@section('title', 'Buku Alamat - Claps Coffee')

@section('account_content')
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-[#EBE1D7]">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight">Buku Alamat</h1>
            <a href="{{ route('customer.addresses.create') }}" class="px-5 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold transition-all shadow-md flex items-center gap-2">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Alamat
            </a>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-2xl flex items-center gap-3">
                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span class="font-bold text-[14px]">{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($addresses as $address)
                <div class="bg-white p-6 rounded-3xl border {{ $address->is_default ? 'border-[#8C4A15] shadow-md' : 'border-[#EBE1D7] shadow-sm' }} relative group">
                    @if($address->is_default)
                        <span class="absolute top-6 right-6 bg-[#FCF8F2] text-[#8C4A15] text-[11px] font-black tracking-wider uppercase px-3 py-1 rounded-lg border border-[#EBE1D7]">Utama</span>
                    @endif
                    
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-full bg-[#F5F2F0] flex items-center justify-center text-[#8C4A15]">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        </div>
                        <h3 class="font-bold text-gray-900 text-lg">{{ $address->label }}</h3>
                    </div>

                    <p class="text-[14px] text-gray-600 mb-6 line-clamp-2 h-[42px]">{{ $address->full_address }}</p>

                    <div class="flex items-center gap-3 pt-4 border-t border-[#EBE1D7]">
                        <a href="{{ route('customer.addresses.edit', $address) }}" class="text-[13px] font-bold text-gray-500 hover:text-gray-900 transition-colors">Edit</a>
                        
                        <form action="{{ route('customer.addresses.destroy', $address) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus alamat ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-[13px] font-bold text-gray-500 hover:text-red-600 transition-colors">Hapus</button>
                        </form>

                        @if(!$address->is_default)
                            <form action="{{ route('customer.addresses.default', $address) }}" method="POST" class="inline ml-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="text-[13px] font-bold text-[#8C4A15] hover:underline">Jadikan Utama</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center bg-[#FCF8F2] rounded-3xl border border-dashed border-[#EBE1D7]">
                    <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mb-4 shadow-sm">
                        <svg class="w-8 h-8 text-gray-400" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    </div>
                    <p class="text-gray-500 font-medium text-[15px] mb-6">Belum ada alamat yang disimpan.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection
