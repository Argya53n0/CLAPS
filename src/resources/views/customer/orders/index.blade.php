@extends('customer.account-layout')

@section('title', 'Riwayat Pesanan - Claps Coffee')

@section('account_content')
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-[#EBE1D7]">
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight mb-8">My Orders</h1>

        @if($orders->count() > 0)
            <div class="space-y-4">
                @foreach($orders as $order)
                    <a href="{{ route('customer.orders.show', $order) }}" class="block bg-white rounded-2xl border border-[#EBE1D7] p-6 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
                            <div>
                                <div class="text-[12px] text-gray-500 font-bold tracking-wide uppercase mb-1">{{ $order->created_at->format('d M Y, H:i') }}</div>
                                <div class="text-lg font-bold font-serif text-gray-900 group-hover:text-[#8C4A15] transition-colors">{{ $order->order_code }}</div>
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
                            
                            <span class="inline-flex items-center justify-center px-4 py-1.5 rounded-full text-[12px] font-bold border {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-4">
                            <div class="text-[13px] text-gray-500 font-medium">
                                {{ $order->items->count() }} Items
                            </div>
                            <div class="text-[15px] font-extrabold text-gray-900">
                                {{ $order->formatted_total }}
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            
            @if($orders->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $orders->links() }}
                </div>
            @endif
        @else
            <div class="text-center py-20 bg-white rounded-3xl border border-[#EBE1D7]">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
                <h3 class="text-lg font-bold font-serif text-gray-900 mb-2">Belum ada pesanan</h3>
                <p class="text-gray-500 text-[14px] mb-6">Kamu belum pernah membuat pesanan. Yuk, lihat menu kami!</p>
                <a href="{{ route('menu') }}" class="px-6 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[13px] font-bold transition-colors inline-block">
                    Lihat Menu
                </a>
            </div>
        @endif
    </div>
@endsection
