@extends('admin.layout')

@section('title', 'Karyawan Dashboard')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold font-serif text-[#8C4A15] tracking-tight mb-2">Halo, {{ auth()->user()->name }}</h1>
        <p class="text-[15px] text-gray-500 font-medium">Ini ringkasan tugas kamu hari ini.</p>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        {{-- Card 1 --}}
        <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-xl bg-yellow-50 text-yellow-600 flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                </div>
                <div class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">Pesanan Masuk</div>
            </div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $incomingOrders }}</div>
        </div>

        {{-- Card 2 --}}
        <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                </div>
                <div class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">Sedang Disiapkan</div>
            </div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $preparingOrders }}</div>
        </div>

        {{-- Card 3 --}}
        <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="8" width="18" height="12" rx="2" ry="2"/><path d="M3 13h18"/></svg>
                </div>
                <div class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">Siap Diambil</div>
            </div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $readyOrders }}</div>
        </div>
        
        {{-- Card 4 --}}
        <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-12 h-12 rounded-xl bg-green-50 text-green-600 flex items-center justify-center">
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
                </div>
                <div class="text-[13px] font-bold text-gray-500 uppercase tracking-wider">Selesai Hari Ini</div>
            </div>
            <div class="text-3xl font-extrabold text-gray-900">{{ $completedToday }}</div>
        </div>
    </div>

    {{-- Active Orders List --}}
    <div class="bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-[#EBE1D7] flex items-center justify-between">
            <h2 class="text-lg font-bold font-serif text-gray-900">Pesanan Aktif (Butuh Tindakan)</h2>
            <a href="{{ route('admin.orders') }}" class="text-[13px] font-bold text-[#8C4A15] hover:underline">Kelola Semua Pesanan →</a>
        </div>
        <div class="p-6">
            @if($activeOrders->count() > 0)
                <div class="space-y-4">
                    @foreach($activeOrders as $order)
                         <div class="flex items-center justify-between p-4 bg-[#FCF8F2] rounded-2xl border border-[#EBE1D7]">
                             <div>
                                 <div class="font-bold text-gray-900 mb-1">{{ $order->order_code }}</div>
                                 <div class="text-[13px] text-gray-600">{{ $order->items->count() }} item • {{ $order->user->name ?? 'Customer' }}</div>
                             </div>
                             @php
                                $statusStyles = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                    'preparing' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'delivery' => 'bg-purple-100 text-purple-800 border-purple-200',
                                ];
                            @endphp
                            <div class="flex items-center gap-4">
                                <span class="px-3 py-1 rounded-full text-[11px] font-bold border {{ $statusStyles[$order->status] ?? 'bg-gray-100' }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <a href="{{ route('admin.orders') }}" class="px-4 py-2 bg-white border border-[#EBE1D7] text-gray-700 rounded-xl text-[12px] font-bold hover:bg-gray-50">Proses</a>
                            </div>
                         </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-gray-500 font-medium">Bagus! Tidak ada pesanan aktif saat ini.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
