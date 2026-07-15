@extends('customer.account-layout')

@section('title', 'Detail Pesanan ' . $order->order_code)

@section('account_content')
    <div class="w-full">
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
                        'pending' => 'Pending',
                        'preparing' => 'Preparing',
                        'delivery' => 'Delivery',
                        'completed' => 'Completed',
                        'cancelled' => 'Dibatalkan',
                    ];
                @endphp
                <div class="px-4 py-2 rounded-xl text-[13px] font-bold border text-center md:text-right {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </div>
            </div>

            {{-- Order Timeline --}}
            <div class="p-6 md:px-8 md:py-6 border-b border-[#EBE1D7] bg-[#FCF8F2]">
                @php
                    $steps = ['pending', 'preparing', 'delivery', 'completed'];
                    $currentIndex = array_search($order->status, $steps);
                    if($currentIndex === false) $currentIndex = -1; // e.g. cancelled
                @endphp
                
                @if($order->status !== 'cancelled')
                    <div class="relative flex items-center justify-between w-full max-w-xl mx-auto">
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 w-full h-1 bg-gray-200 rounded-full z-0"></div>
                        <div class="absolute left-0 top-1/2 transform -translate-y-1/2 h-1 bg-[#8C4A15] rounded-full z-0 transition-all duration-500" style="width: {{ $currentIndex > 0 ? ($currentIndex / (count($steps) - 1)) * 100 : 0 }}%"></div>
                        
                        @foreach($steps as $stepIdx => $step)
                            @php
                                $isCompleted = $stepIdx <= $currentIndex;
                                $isActive = $stepIdx === $currentIndex;
                                $currentStepIdx = $currentIndex;
                            @endphp
                            <div class="relative z-10 flex flex-col items-center gap-2">
                                <div class="w-8 h-8 rounded-full flex items-center justify-center border-2 {{ $isCompleted ? 'bg-[#8C4A15] border-[#8C4A15] text-white shadow-md' : 'bg-white border-gray-300 text-gray-400' }} transition-colors">
                                    @if($isCompleted)
                                        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"/></svg>
                                    @else
                                        <div class="w-2.5 h-2.5 rounded-full {{ $isActive ? 'bg-[#8C4A15]' : 'bg-transparent' }}"></div>
                                    @endif
                                </div>
                                <div class="text-[11px] font-bold mt-2 uppercase tracking-widest
                                    {{ $stepIdx < $currentStepIdx ? 'text-[#8C4A15]' : ($stepIdx === $currentStepIdx ? 'text-[#8C4A15]' : 'text-gray-400') }}">
                                    {{ $step }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-red-600 font-bold text-[14px]">
                        Pesanan ini telah dibatalkan.
                    </div>
                @endif
            </div>

            {{-- Delivery Info --}}
            @if($order->delivery_address)
                <div class="p-6 md:p-8 border-b border-[#EBE1D7]">
                    <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                        Lokasi Pengiriman
                    </h3>

                    {{-- Mini Map --}}
                    @if($order->delivery_lat && $order->delivery_lng)
                        <div id="order-map" class="w-full h-40 rounded-xl mb-3 border border-[#EBE1D7] z-10"></div>
                    @endif

                    <p class="text-[14px] text-gray-800 bg-[#FCF8F2] p-4 rounded-xl border border-[#EBE1D7]">{{ $order->delivery_address }}</p>
                </div>
            @endif

            {{-- Payment Info --}}
            <div class="p-6 md:p-8 border-b border-[#EBE1D7]">
                <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect width="20" height="14" x="2" y="5" rx="2"/><line x1="2" x2="22" y1="10" y2="10"/></svg>
                    Pembayaran
                </h3>

                <div class="flex flex-col sm:flex-row sm:items-center gap-4">
                    <div class="flex-1">
                        <div class="text-[13px] text-gray-500 mb-1">Metode</div>
                        <div class="font-bold text-[15px] text-gray-900">
                            @if($order->payment_method === 'qris')
                                QRIS (Scan & Bayar)
                            @else
                                Bayar di Tempat (COD)
                            @endif
                        </div>
                    </div>
                    <div>
                        <div class="text-[13px] text-gray-500 mb-1">Status</div>
                        @php
                            $paymentStatusStyles = [
                                'unpaid' => 'bg-yellow-100 text-yellow-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'failed' => 'bg-red-100 text-red-800',
                            ];
                            $paymentStatusLabels = [
                                'unpaid' => 'Belum Dibayar',
                                'paid' => 'Sudah Dibayar',
                                'failed' => 'Gagal',
                            ];
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-lg text-[13px] font-bold {{ $paymentStatusStyles[$order->payment_status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $paymentStatusLabels[$order->payment_status] ?? ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>

                {{-- QRIS Mockup --}}
                @if($order->payment_method === 'qris' && $order->payment_status === 'unpaid')
                    <div class="mt-6 p-6 bg-[#FCF8F2] rounded-2xl border border-[#EBE1D7] text-center">
                        <p class="text-[13px] font-bold text-gray-500 uppercase tracking-wider mb-4">Scan QR Code Untuk Membayar</p>
                        
                        <div class="w-48 h-48 mx-auto bg-white rounded-xl shadow-sm border border-[#EBE1D7] overflow-hidden mb-4 p-2 relative">
                            <img src="{{ asset('images/qris_mockup.png') }}" alt="QRIS" class="w-full h-full object-contain mix-blend-multiply">
                        </div>

                        <p class="text-[12px] text-gray-400 mb-4">QR Code ini valid selama 24 jam sejak pesanan dibuat.</p>
                        
                        <p class="text-[14px] text-gray-600 font-medium mb-4">Total: <span class="font-bold text-gray-900 text-lg">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span></p>

                        <form action="{{ route('customer.orders.simulate_payment', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[13px] font-bold transition-all shadow-md">
                                <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Simulasi Pembayaran Sukses
                            </button>
                        </form>
                    </div>
                @endif
            </div>

            {{-- Items --}}
            <div class="p-6 md:p-8 border-b border-[#EBE1D7]">
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
                                <p class="text-[13px] text-gray-500 mb-1">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                                @if(!empty($item->options))
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($item->options as $key => $val)
                                            <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[11px] font-medium border border-gray-200">
                                                {{ $val }}
                                            </span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="text-right shrink-0">
                                <div class="font-bold text-[14px] text-gray-900">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Summary --}}
            <div class="p-6 md:p-8 bg-[#FCF8F2] border-b border-[#EBE1D7]">
                @if($order->notes)
                    <div class="mb-6">
                        <h4 class="text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Pesanan</h4>
                        <p class="text-[14px] text-gray-800 bg-white p-4 rounded-xl border border-[#EBE1D7]">{{ $order->notes }}</p>
                    </div>
                @endif

                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-[14px]">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="font-bold text-gray-900">{{ $order->formatted_total }}</span>
                    </div>
                    @if($order->shipping_fee > 0)
                        <div class="flex justify-between text-[14px]">
                            <span class="text-gray-500">Ongkos Kirim</span>
                            <span class="font-bold text-gray-900">{{ $order->formatted_shipping }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex justify-between items-center text-lg font-extrabold text-gray-900 border-t border-[#EBE1D7] pt-4">
                    <span>Total Pembayaran</span>
                    <span class="font-serif text-xl text-[#8C4A15]">{{ $order->formatted_grand_total }}</span>
                </div>
            </div>

            {{-- Rating Section --}}
            @if($order->status === 'completed')
                <div class="p-6 md:p-8">
                    @if($order->rating)
                        {{-- Already Rated --}}
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Penilaian Anda
                        </h3>
                        <div class="bg-[#FCF8F2] rounded-2xl p-5 border border-[#EBE1D7]">
                            <div class="flex items-center gap-1 mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $order->rating ? 'text-yellow-400' : 'text-gray-300' }}" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                @endfor
                                <span class="ml-2 text-[14px] font-bold text-gray-700">{{ $order->rating }}/5</span>
                            </div>
                            @if($order->review)
                                <p class="text-[14px] text-gray-700 italic">"{{ $order->review }}"</p>
                            @endif
                        </div>
                    @else
                        {{-- Rating Form --}}
                        <h3 class="font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#8C4A15]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            Berikan Penilaian
                        </h3>
                        <form action="{{ route('customer.orders.rate', $order) }}" method="POST" class="bg-[#FCF8F2] rounded-2xl p-5 border border-[#EBE1D7]">
                            @csrf
                            <p class="text-[13px] text-gray-500 mb-4">Bagaimana pengalaman pesanan Anda?</p>

                            {{-- Star Rating --}}
                            <div class="flex items-center gap-1 mb-5" id="star-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    <button type="button" data-value="{{ $i }}" class="star-btn focus:outline-none transition-transform hover:scale-110">
                                        <svg class="w-8 h-8 text-gray-300 transition-colors" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                                    </button>
                                @endfor
                            </div>
                            <input type="hidden" name="rating" id="rating-input" value="" required>

                            {{-- Review Text --}}
                            <textarea name="review" rows="2" placeholder="Ceritakan pengalaman Anda (opsional)..." class="w-full bg-white border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] resize-none transition-all mb-4"></textarea>

                            <button type="submit" id="submit-rating" disabled class="w-full bg-[#8C4A15] hover:bg-[#723C10] disabled:bg-gray-300 disabled:cursor-not-allowed text-white py-3 rounded-xl text-[14px] font-bold transition-all">
                                Kirim Penilaian
                            </button>
                        </form>
                    @endif
                </div>
            @elseif($order->status === 'cancelled')
                <div class="p-6 md:p-8">
                    <div class="bg-red-50 rounded-2xl p-6 border border-red-100 text-center">
                        <svg class="w-12 h-12 text-red-500 mx-auto mb-3" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        <h3 class="font-bold text-red-900 text-lg mb-1">Pesanan Dibatalkan</h3>
                        @if($order->cancellation_reason)
                            <p class="text-[14px] text-red-700 mt-2">Alasan: <span class="font-bold">{{ $order->cancellation_reason }}</span></p>
                        @endif
                        <p class="text-[13px] text-red-600 mt-2">Mohon maaf atas ketidaknyamanan ini. Silakan hubungi admin untuk info lebih lanjut.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@if($order->delivery_lat && $order->delivery_lng)
    @push('styles')
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
        <style>
            .leaflet-container { font-family: 'Inter', sans-serif; z-index: 10; }
        </style>
    @endpush

    @push('scripts')
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const lat = {{ $order->delivery_lat }};
                const lng = {{ $order->delivery_lng }};

                const map = L.map('order-map', { scrollWheelZoom: false }).setView([lat, lng], 16);
                L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                    maxZoom: 19,
                    attribution: '&copy; OpenStreetMap'
                }).addTo(map);

                const customIcon = L.divIcon({
                    className: 'custom-div-icon',
                    html: `<div style="background-color:#8C4A15;width:20px;height:20px;border-radius:50%;border:3px solid white;box-shadow:0 4px 6px rgba(0,0,0,0.3);"></div>`,
                    iconSize: [20, 20],
                    iconAnchor: [10, 10]
                });

                L.marker([lat, lng], {icon: customIcon}).addTo(map);
            });
        </script>
    @endpush
@endif

@if($order->status === 'completed' && !$order->rating)
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const stars = document.querySelectorAll('.star-btn');
                const ratingInput = document.getElementById('rating-input');
                const submitBtn = document.getElementById('submit-rating');
                let selectedRating = 0;

                stars.forEach(btn => {
                    btn.addEventListener('click', function() {
                        selectedRating = parseInt(this.dataset.value);
                        ratingInput.value = selectedRating;
                        submitBtn.disabled = false;

                        stars.forEach((s, index) => {
                            const svg = s.querySelector('svg');
                            if (index < selectedRating) {
                                svg.classList.remove('text-gray-300');
                                svg.classList.add('text-yellow-400');
                            } else {
                                svg.classList.remove('text-yellow-400');
                                svg.classList.add('text-gray-300');
                            }
                        });
                    });

                    btn.addEventListener('mouseenter', function() {
                        const hoverVal = parseInt(this.dataset.value);
                        stars.forEach((s, index) => {
                            const svg = s.querySelector('svg');
                            if (index < hoverVal) {
                                svg.classList.remove('text-gray-300');
                                svg.classList.add('text-yellow-400');
                            } else {
                                svg.classList.remove('text-yellow-400');
                                svg.classList.add('text-gray-300');
                            }
                        });
                    });
                });

                document.getElementById('star-rating').addEventListener('mouseleave', function() {
                    stars.forEach((s, index) => {
                        const svg = s.querySelector('svg');
                        if (index < selectedRating) {
                            svg.classList.remove('text-gray-300');
                            svg.classList.add('text-yellow-400');
                        } else {
                            svg.classList.remove('text-yellow-400');
                            svg.classList.add('text-gray-300');
                        }
                    });
                });
            });
        </script>
    @endpush
@endif
