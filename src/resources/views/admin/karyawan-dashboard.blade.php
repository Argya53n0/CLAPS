@extends('admin.layout')

@section('title', 'Karyawan Dashboard - KDS')

@section('content')
    {{-- Header & Compact Stats --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
        <div>
            <h1 class="text-3xl font-extrabold font-serif text-[#8C4A15] tracking-tight mb-1">Kitchen Display System</h1>
            <p class="text-[14px] text-gray-500 font-medium">Shift: {{ auth()->user()->name }} &bull; {{ now()->format('d M Y, H:i') }}</p>
        </div>

        <div class="flex items-center gap-3">
            <div class="bg-white px-4 py-2 rounded-xl border border-[#EBE1D7] shadow-sm text-center">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Selesai Hari Ini</div>
                <div class="text-xl font-extrabold text-green-600 leading-none">{{ $completedToday }}</div>
            </div>
            <div class="bg-white px-4 py-2 rounded-xl border border-[#EBE1D7] shadow-sm text-center">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Total Aktif</div>
                <div class="text-xl font-extrabold text-[#8C4A15] leading-none">{{ $activeOrders->count() }}</div>
            </div>
        </div>
    </div>

    @php
        $pending = $activeOrders->where('status', 'pending');
        $preparing = $activeOrders->where('status', 'preparing');
        $delivery = $activeOrders->where('status', 'delivery');
    @endphp

    {{-- KDS Kanban Board --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-start">
        
        {{-- Column 1: PENDING (Baru Masuk) --}}
        <div class="flex flex-col gap-4">
            <div class="bg-yellow-50 border-t-4 border-yellow-400 rounded-2xl p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-yellow-400 animate-pulse"></div>
                    <h2 class="font-bold text-yellow-900">1. Pending</h2>
                </div>
                <span class="bg-yellow-200 text-yellow-800 text-[12px] font-extrabold px-2.5 py-0.5 rounded-full">{{ $pending->count() }}</span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($pending as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-[#EBE1D7] overflow-hidden flex flex-col">
                        {{-- Header Card --}}
                        <div class="bg-gray-50 border-b border-[#EBE1D7] px-4 py-3 flex justify-between items-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-extrabold text-[#8C4A15] hover:underline">#{{ $order->order_code }}</a>
                            <span class="text-[11px] font-bold text-gray-500">{{ $order->created_at->diffForHumans() }}</span>
                        </div>
                        
                        {{-- Customer Info --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-[#FCF8F2]/50">
                            <div class="font-bold text-gray-800 text-[14px]">{{ $order->user->name ?? 'Customer' }}</div>
                            @if($order->delivery_lat && $order->delivery_lng)
                                <a href="https://www.google.com/maps?q={{ $order->delivery_lat }},{{ $order->delivery_lng }}" target="_blank" class="inline-flex mt-1.5 items-center gap-1 text-[11px] font-bold text-blue-600 hover:text-blue-800">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Cek Rute Google Maps
                                </a>
                            @endif
                        </div>

                        {{-- Order Items --}}
                        <div class="p-4 grow flex flex-col gap-3">
                            @foreach($order->items as $item)
                                <div class="flex gap-3 items-start">
                                    <div class="bg-[#F5E6D8] text-[#8C4A15] font-extrabold w-6 h-6 rounded flex items-center justify-center shrink-0 text-[13px]">
                                        {{ $item->quantity }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[14px] leading-tight">{{ $item->product->name ?? 'Item' }}</div>
                                        @if($item->options && is_array($item->options) && count($item->options) > 0)
                                            <ul class="mt-1 space-y-0.5">
                                                @foreach($item->options as $key => $val)
                                                    <li class="text-[11px] font-bold text-gray-500 uppercase tracking-wide flex items-center gap-1.5">
                                                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                                        {{ $key }}: <span class="text-gray-700">{{ $val }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Action Button --}}
                        <div class="p-3 border-t border-gray-100 bg-gray-50">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="preparing">
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-xl text-[13px] transition-colors flex items-center justify-center gap-2">
                                    Mulai Buat
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center text-gray-400 font-medium">
                        Kosong
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Column 2: PREPARING (Sedang Diracik) --}}
        <div class="flex flex-col gap-4">
            <div class="bg-blue-50 border-t-4 border-blue-500 rounded-2xl p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-blue-500"></div>
                    <h2 class="font-bold text-blue-900">2. Preparing</h2>
                </div>
                <span class="bg-blue-200 text-blue-800 text-[12px] font-extrabold px-2.5 py-0.5 rounded-full">{{ $preparing->count() }}</span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($preparing as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-[#EBE1D7] overflow-hidden flex flex-col border-l-4 border-l-blue-500">
                        {{-- Header Card --}}
                        <div class="bg-gray-50 border-b border-[#EBE1D7] px-4 py-3 flex justify-between items-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-extrabold text-[#8C4A15] hover:underline">#{{ $order->order_code }}</a>
                            <span class="text-[11px] font-bold text-blue-600">{{ $order->updated_at->diffForHumans() }}</span>
                        </div>

                        {{-- Order Items (Simplified for Preparing) --}}
                        <div class="p-4 grow flex flex-col gap-3">
                            <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-1">Daftar Item:</div>
                            @foreach($order->items as $item)
                                <div class="flex gap-3 items-start">
                                    <div class="font-extrabold text-blue-600 text-[13px]">{{ $item->quantity }}x</div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-[14px] leading-tight">{{ $item->product->name ?? 'Item' }}</div>
                                        @if($item->options && is_array($item->options) && count($item->options) > 0)
                                            <ul class="mt-0.5 flex flex-wrap gap-1">
                                                @foreach($item->options as $key => $val)
                                                    <li class="text-[9px] font-bold bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded">{{ $val }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Action Button --}}
                        <div class="p-3 border-t border-gray-100 bg-gray-50">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="delivery">
                                <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-2.5 rounded-xl text-[13px] transition-colors flex items-center justify-center gap-2">
                                    Antar Sekarang
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14"/><polyline points="12 5 19 12 12 19"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center text-gray-400 font-medium">
                        Tidak ada pesanan diracik
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Column 3: DELIVERY (Sedang Diantar) --}}
        <div class="flex flex-col gap-4">
            <div class="bg-green-50 border-t-4 border-green-500 rounded-2xl p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-2.5 h-2.5 rounded-full bg-green-500 animate-pulse"></div>
                    <h2 class="font-bold text-green-900">3. Delivery</h2>
                </div>
                <span class="bg-green-200 text-green-800 text-[12px] font-extrabold px-2.5 py-0.5 rounded-full">{{ $delivery->count() }}</span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($delivery as $order)
                    <div class="bg-white rounded-2xl shadow-sm border border-[#EBE1D7] overflow-hidden flex flex-col border-l-4 border-l-green-500 opacity-90 hover:opacity-100 transition-opacity">
                        {{-- Header Card --}}
                        <div class="bg-gray-50 border-b border-[#EBE1D7] px-4 py-3 flex justify-between items-center">
                            <a href="{{ route('admin.orders.show', $order) }}" class="font-extrabold text-[#8C4A15] hover:underline">#{{ $order->order_code }}</a>
                            <span class="text-[11px] font-bold text-green-600">Dalam perjalanan</span>
                        </div>
                        
                        {{-- Customer Info --}}
                        <div class="px-4 py-3 border-b border-gray-100 bg-[#FCF8F2]/50">
                            <div class="font-bold text-gray-800 text-[14px]">{{ $order->user->name ?? 'Customer' }}</div>
                            @if($order->delivery_lat && $order->delivery_lng)
                                <a href="https://www.google.com/maps?q={{ $order->delivery_lat }},{{ $order->delivery_lng }}" target="_blank" class="inline-flex mt-1.5 items-center gap-1 text-[11px] font-bold text-blue-600 hover:text-blue-800">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                                    Cek Rute Google Maps
                                </a>
                            @endif
                        </div>

                        <div class="p-4 grow">
                            <div class="text-[13px] font-bold text-gray-500 mb-1">{{ $order->items->count() }} Items Total</div>
                            <div class="text-[11px] text-gray-400 font-medium">Pesanan sedang dalam perjalanan ke customer.</div>
                        </div>

                        {{-- Action Button --}}
                        <div class="p-3 border-t border-gray-100 bg-gray-50">
                            <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="completed">
                                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 rounded-xl text-[13px] transition-colors flex items-center justify-center gap-2">
                                    Pesanan Sampai
                                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-8 text-center text-gray-400 font-medium">
                        Tidak ada pesanan diantar
                    </div>
                @endforelse
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let latestTime = {{ $pending->first() ? $pending->first()->created_at->timestamp : 0 }};
            
            function playBeep() {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gainNode = ctx.createGain();
                
                osc.type = 'sine';
                osc.frequency.setValueAtTime(880, ctx.currentTime); // A5 note
                
                gainNode.gain.setValueAtTime(0.1, ctx.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.5);
                
                osc.connect(gainNode);
                gainNode.connect(ctx.destination);
                
                osc.start();
                osc.stop(ctx.currentTime + 0.5);
            }

            setInterval(async () => {
                try {
                    const res = await fetch("{{ route('admin.karyawan.check_new') }}");
                    const data = await res.json();
                    
                    if (data.latest_time > latestTime) {
                        playBeep();
                        // Wait a bit for beep to play before reloading
                        setTimeout(() => {
                            window.location.reload();
                        }, 500);
                    }
                } catch (e) {
                    console.error('Polling error', e);
                }
            }, 10000); // Poll every 10s
        });
    </script>
@endsection
