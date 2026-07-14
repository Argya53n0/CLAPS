@extends('customer.layout')

@section('title', 'Detail Pesanan ' . $order->order_code)

@section('content')
    <div class="max-w-3xl mx-auto px-6 lg:px-12 py-12">
        <a href="{{ route('customer.orders') }}" class="inline-flex items-center gap-2 text-[13px] font-bold text-gray-500 hover:text-[#8C4A15] transition-colors mb-6">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Riwayat
        </a>

        <div class="bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden">
            {{-- Header --}}
            <div class="p-6 md:p-8 border-b border-[#EBE1D7] flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-extrabold font-serif text-gray-900 mb-1">{{ $order->order_code }}</h1>
                    <p class="text-[13px] text-gray-500">{{ $order->created_at->format('d M Y, H:i') }}</p>
                </div>
                
                @php
                    $statusStyles = [
                        'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                        'preparing' => 'bg-blue-100 text-blue-800 border-blue-200',
                        'delivery' => 'bg-purple-100 text-purple-800 border-purple-200',
                        'completed' => 'bg-green-100 text-green-800 border-green-200',
                        'cancelled' => 'bg-red-100 text-red-800 border-red-200',
                    ];
                    $statusLabels = [
                        'pending' => 'Menunggu Konfirmasi',
                        'preparing' => 'Sedang Disiapkan',
                        'delivery' => 'Siap Diambil / Diantar',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                <div class="px-4 py-2 rounded-xl text-[13px] font-bold border text-center md:text-right {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </div>
            </div>

            {{-- Items --}}
            <div class="p-6 md:p-8">
                <h3 class="font-bold text-gray-900 mb-4">Item Pesanan</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-[#F5F2F0] shrink-0 overflow-hidden">
                                @if($item->product && $item->product->image)
                                    <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-gray-900 text-[14px]">{{ $item->product ? $item->product->name : 'Produk Dihapus' }}</h4>
                                <p class="text-[13px] text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="font-bold text-[14px] text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary --}}
            <div class="p-6 md:p-8 bg-[#FCF8F2] border-t border-[#EBE1D7]">
                @if($order->notes)
                    <div class="mb-6">
                        <h4 class="text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Pesanan</h4>
                        <p class="text-[14px] text-gray-800 bg-white p-4 rounded-xl border border-[#EBE1D7]">{{ $order->notes }}</p>
                    </div>
                @endif

                <div class="flex justify-between items-center text-lg font-extrabold text-gray-900">
                    <span>Total Pembayaran</span>
                    <span class="font-serif text-xl text-[#8C4A15]">{{ $order->formatted_total }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
