@extends('admin.layout')

@section('title', 'Detail Pesanan #' . $order->order_code)

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <a href="{{ url()->previous() }}" class="w-8 h-8 rounded-full bg-white border border-[#EBE1D7] flex items-center justify-center text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-colors">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                <h1 class="text-3xl font-extrabold font-serif text-[#8C4A15] tracking-tight">Detail Pesanan</h1>
                
                <a href="{{ route('admin.orders.print', $order) }}" target="_blank" class="ml-4 px-4 py-2 bg-white border border-[#EBE1D7] text-gray-700 hover:bg-gray-50 rounded-xl text-[13px] font-bold flex items-center gap-2 transition-colors shadow-sm">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak Struk
                </a>
            </div>
            <p class="text-[14px] text-gray-500 font-medium ml-11">#{{ $order->order_code }} &bull; {{ $order->created_at->format('d M Y, H:i') }}</p>
        </div>
        
        <div class="bg-white px-5 py-3 rounded-2xl border border-[#EBE1D7] shadow-sm flex items-center gap-3">
            <span class="text-[12px] font-bold text-gray-500">Status:</span>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'preparing' => 'bg-blue-100 text-blue-800',
                    'delivery' => 'bg-purple-100 text-purple-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                ];
                $color = $statusColors[$order->status] ?? 'bg-gray-100 text-gray-800';
            @endphp
            <span class="px-3 py-1 rounded-lg text-[12px] font-bold uppercase tracking-wider {{ $color }}">
                {{ $order->status }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Order Items & Pricing --}}
        <div class="lg:col-span-2 flex flex-col gap-6">
            {{-- Order Items --}}
            <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
                <h2 class="text-lg font-bold font-serif text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Daftar Item
                </h2>
                
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex gap-4 p-4 bg-[#FCF8F2] rounded-2xl border border-[#F5E6D8]">
                            {{-- Image --}}
                            <div class="w-20 h-20 rounded-xl bg-white border border-[#EBE1D7] flex-shrink-0 overflow-hidden flex items-center justify-center">
                                @if($item->product->image)
                                    <img src="{{ $item->product->image }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                @endif
                            </div>
                            
                            {{-- Details --}}
                            <div class="flex-grow">
                                <div class="flex justify-between items-start mb-1">
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name ?? 'Produk Terhapus' }}</h3>
                                    <div class="font-extrabold text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                                </div>
                                <div class="text-[13px] font-bold text-[#8C4A15] mb-2">{{ $item->quantity }}x @ Rp {{ number_format($item->price, 0, ',', '.') }}</div>
                                
                                @if($item->options && is_array($item->options) && count($item->options) > 0)
                                    <div class="flex flex-wrap gap-2 mt-2">
                                        @foreach($item->options as $key => $val)
                                            <span class="px-2 py-1 bg-white rounded-md border border-[#EBE1D7] text-[11px] font-bold text-gray-600 uppercase tracking-wide">
                                                {{ $key }}: <span class="text-gray-900">{{ $val }}</span>
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary & Totals --}}
            <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
                <h2 class="text-lg font-bold font-serif text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><path d="M8 14h.01"/><path d="M12 14h.01"/><path d="M16 14h.01"/><path d="M8 18h.01"/><path d="M12 18h.01"/><path d="M16 18h.01"/></svg>
                    Ringkasan Biaya
                </h2>
                
                <div class="space-y-3 mb-6 text-[14px]">
                    <div class="flex justify-between text-gray-600 font-medium">
                        <span>Subtotal ({{ $order->items->sum('quantity') }} items)</span>
                        <span class="font-bold text-gray-900">{{ $order->formatted_total }}</span>
                    </div>
                    <div class="flex justify-between text-gray-600 font-medium">
                        <span>Ongkos Kirim (Flat)</span>
                        <span class="font-bold text-gray-900">{{ $order->formatted_shipping }}</span>
                    </div>
                </div>
                
                <div class="pt-4 border-t border-dashed border-gray-300 flex justify-between items-center">
                    <span class="font-bold text-gray-900">Total Pembayaran</span>
                    <span class="text-2xl font-extrabold text-[#8C4A15]">{{ $order->formatted_grand_total }}</span>
                </div>
                
                <div class="mt-6 p-4 bg-[#FCF8F2] rounded-xl border border-[#F5E6D8] flex items-start gap-3">
                    <div class="mt-0.5 text-[#8C4A15]">
                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="2" y="5" width="20" height="14" rx="2"/><line x1="2" y1="10" x2="22" y2="10"/></svg>
                    </div>
                    <div>
                        <div class="text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-1">Metode Pembayaran</div>
                        <div class="font-extrabold text-gray-900 text-[15px] uppercase">{{ $order->payment_method }}</div>
                        <div class="text-[12px] font-bold mt-1 {{ $order->payment_status === 'paid' ? 'text-green-600' : 'text-yellow-600' }}">
                            {{ $order->payment_status === 'paid' ? 'SUDAH DIBAYAR' : 'BELUM DIBAYAR' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Customer & Delivery --}}
        <div class="flex flex-col gap-6">
            {{-- Update Status Action --}}
            <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
                <h2 class="text-lg font-bold font-serif text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
                    Update Status
                </h2>
                
                <form action="{{ route('admin.orders.status', $order) }}" method="POST" class="flex flex-col gap-4">
                    @csrf
                    @method('PATCH')
                    
                    <div class="relative">
                        <select name="status" id="status-select" class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[14px] font-bold text-gray-900 focus:ring-1 focus:ring-[#8C4A15] appearance-none cursor-pointer" onchange="toggleCancelReason()">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                            <option value="delivery" {{ $order->status === 'delivery' ? 'selected' : '' }}>Delivery</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-[#8C4A15]">
                            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 12 15 18 9"/></svg>
                        </div>
                    </div>
                    
                    <div id="cancel-reason-container" class="{{ $order->status === 'cancelled' ? 'block' : 'hidden' }}">
                        <label class="block text-[12px] font-bold text-gray-600 mb-2">Alasan Pembatalan (Bila dicancel):</label>
                        <textarea name="cancellation_reason" rows="2" class="w-full bg-white border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15]" placeholder="Misal: Susu almond habis...">{{ $order->cancellation_reason }}</textarea>
                    </div>

                    <script>
                        function toggleCancelReason() {
                            const select = document.getElementById('status-select');
                            const container = document.getElementById('cancel-reason-container');
                            if (select.value === 'cancelled') {
                                container.classList.remove('hidden');
                                container.classList.add('block');
                            } else {
                                container.classList.remove('block');
                                container.classList.add('hidden');
                            }
                        }
                    </script>
                    
                    <button type="submit" class="w-full bg-[#8C4A15] hover:bg-[#723C10] text-white py-3 rounded-xl font-bold text-[14px] transition-colors shadow-md">
                        Simpan Perubahan
                    </button>
                </form>
            </div>

            {{-- Customer Info --}}
            <div class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm">
                <h2 class="text-lg font-bold font-serif text-gray-900 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Informasi Pelanggan
                </h2>
                
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-12 h-12 rounded-full bg-[#FCF8F2] text-[#8C4A15] font-extrabold text-lg flex items-center justify-center">
                        {{ strtoupper(substr($order->user->name ?? 'C', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-gray-900">{{ $order->user->name ?? 'Customer' }}</div>
                        <div class="text-[13px] text-gray-500 font-medium">{{ $order->user->email ?? 'No email' }}</div>
                    </div>
                </div>
                
                <hr class="border-gray-100 mb-6">
                
                <h3 class="text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Pengiriman</h3>
                <p class="text-[14px] text-gray-800 font-medium leading-relaxed mb-4">
                    {{ $order->delivery_address ?: 'Tidak ada alamat tercatat.' }}
                </p>
                
                @if($order->delivery_lat && $order->delivery_lng)
                    <a href="https://www.google.com/maps?q={{ $order->delivery_lat }},{{ $order->delivery_lng }}" target="_blank" class="w-full bg-blue-50 hover:bg-blue-100 text-blue-700 py-3 rounded-xl font-bold text-[13px] transition-colors flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
                        Buka di Google Maps
                    </a>
                @endif
                
                @if($order->notes)
                    <hr class="border-gray-100 my-6">
                    <h3 class="text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Tambahan</h3>
                    <p class="text-[13px] text-gray-800 bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                        "{{ $order->notes }}"
                    </p>
                @endif
            </div>
        </div>
    </div>
@endsection
