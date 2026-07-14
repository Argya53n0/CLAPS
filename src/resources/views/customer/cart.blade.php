@extends('customer.layout')

@section('title', 'Keranjang - Claps Coffee')

@section('content')
    <div class="max-w-4xl mx-auto px-6 lg:px-12 py-12">
        <h1 class="text-3xl font-extrabold font-serif text-gray-900 tracking-tight mb-8">Shopping Cart</h1>

        @if(count($cartItems) > 0)
            <div class="flex flex-col gap-8">
                {{-- Cart Items --}}
                <div class="space-y-4">
                    <form action="{{ route('customer.cart.update') }}" method="POST" id="cartForm">
                        @csrf
                        @method('PATCH')

                        @foreach($cartItems as $item)
                            <div class="bg-white rounded-2xl border border-[#EBE1D7] p-5 shadow-sm flex items-center gap-5 group">
                                {{-- Image --}}
                                <div class="w-20 h-20 rounded-xl bg-[#F5F2F0] shrink-0 overflow-hidden">
                                    @if($item['product']->image)
                                        <img src="{{ $item['product']->image }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-6 h-6 text-gray-300" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 8h1a4 4 0 1 1 0 8h-1"/><path d="M3 8h14v9a4 4 0 0 1-4 4H7a4 4 0 0 1-4-4Z"/></svg>
                                        </div>
                                    @endif
                                </div>

                                {{-- Info --}}
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-gray-900 text-[15px] mb-0.5">{{ $item['product']->name }}</h3>
                                    <p class="text-[13px] text-gray-500 mb-1">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                                    @if(!empty($item['options']))
                                        <div class="flex flex-wrap gap-1">
                                            @foreach($item['options'] as $key => $val)
                                                <span class="inline-block px-2 py-0.5 bg-gray-100 text-gray-600 rounded text-[11px] font-medium border border-gray-200">
                                                    {{ $val }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                {{-- Quantity --}}
                                <div class="flex items-center gap-2 shrink-0">
                                    <input type="number" name="quantities[{{ $item['cart_item_id'] }}]" value="{{ $item['quantity'] }}" min="0" max="99"
                                           class="w-16 h-10 text-center bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl text-[14px] font-bold focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15]">
                                </div>

                                {{-- Subtotal --}}
                                <div class="text-right shrink-0 w-28">
                                    <div class="font-extrabold text-gray-900 text-[15px]">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</div>
                                </div>

                                {{-- Remove --}}
                                <form action="{{ route('customer.cart.remove', $item['cart_item_id']) }}" method="POST" class="shrink-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-gray-300 hover:text-red-500 transition-colors" title="Remove">
                                        <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach

                        <button type="submit" class="mt-2 px-6 py-2.5 bg-white border border-[#EBE1D7] hover:bg-gray-50 text-gray-700 rounded-xl text-[13px] font-bold transition-colors">
                            Update Cart
                        </button>
                    </form>
                </div>

                {{-- Order Summary & Checkout --}}
                <div class="w-full">
                    <form action="{{ route('customer.checkout') }}" method="POST" id="checkoutForm" class="bg-white rounded-3xl border border-[#EBE1D7] p-6 shadow-sm sticky top-24">
                        @csrf
                        <h3 class="text-lg font-extrabold font-serif text-gray-900 mb-6">Delivery & Payment</h3>

                        {{-- Address Selection --}}
                        <div class="mb-5">
                            <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Pilih Alamat Pengiriman</label>
                            <select id="address_select" class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] font-bold text-gray-800 focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] mb-3">
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}" 
                                            data-lat="{{ $address->lat }}" 
                                            data-lng="{{ $address->lng }}" 
                                            data-full="{{ $address->full_address }}"
                                            {{ $address->is_default ? 'selected' : '' }}>
                                        {{ $address->label }} - {{ Str::limit($address->full_address, 30) }}
                                    </option>
                                @endforeach
                                <option value="manual" {{ count($addresses) == 0 ? 'selected' : '' }}>+ Gunakan Lokasi Baru (Manual)</option>
                            </select>
                        </div>

                        {{-- Manual Map & Address (Hidden by default if addresses exist) --}}
                        <div id="manual_address_section" class="{{ count($addresses) > 0 ? 'hidden' : '' }}">
                            <div class="mb-5">
                                <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Lokasi Baru (Peta)</label>
                                <div id="map" class="w-full h-48 bg-[#F5F2F0] rounded-xl mb-2 z-10 border border-[#EBE1D7]"></div>
                                <button type="button" id="btn-my-location" class="text-[#8C4A15] text-[12px] font-bold hover:underline flex items-center gap-1.5 mt-2">
                                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                    Gunakan Lokasi Saat Ini
                                </button>
                            </div>

                            <div class="mb-5">
                                <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Detail Alamat Lengkap</label>
                                <textarea name="delivery_address" id="delivery_address" rows="2" placeholder="Nama Jalan, RT/RW, Patokan (misal: rumah pagar hitam)" class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] resize-none transition-all"></textarea>
                            </div>
                        </div>

                        <input type="hidden" name="delivery_lat" id="delivery_lat" required>
                        <input type="hidden" name="delivery_lng" id="delivery_lng" required>

                        {{-- Notes --}}
                        <div class="mb-5">
                            <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Catatan Pesanan</label>
                            <textarea name="notes" rows="1" placeholder="Misal: Tanpa es, extra gula..." class="w-full bg-[#FCF8F2] border border-[#EBE1D7] rounded-xl px-4 py-3 text-[13px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] resize-none transition-all"></textarea>
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-6">
                            <label class="block text-[12px] font-bold text-gray-500 uppercase tracking-wider mb-2">Metode Pembayaran</label>
                            <div class="grid grid-cols-2 gap-3">
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="payment_method" value="qris" class="peer sr-only" checked>
                                    <div class="px-4 py-3 border-2 border-[#EBE1D7] rounded-xl text-center text-[13px] font-bold text-gray-500 peer-checked:bg-[#FDF4EB] peer-checked:text-[#8C4A15] peer-checked:border-[#8C4A15] transition-all">
                                        QRIS
                                    </div>
                                </label>
                                <label class="cursor-pointer relative">
                                    <input type="radio" name="payment_method" value="cod" class="peer sr-only">
                                    <div class="px-4 py-3 border-2 border-[#EBE1D7] rounded-xl text-center text-[13px] font-bold text-gray-500 peer-checked:bg-[#FDF4EB] peer-checked:text-[#8C4A15] peer-checked:border-[#8C4A15] transition-all">
                                        Bayar di Tempat
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Order Summary Costs --}}
                        @php $shippingFee = 10000; @endphp
                        <input type="hidden" name="shipping_fee" value="{{ $shippingFee }}">
                        <div class="space-y-3 mb-6 border-t border-gray-100 pt-6">
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Subtotal ({{ count($cartItems) }} Item)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between text-[14px]">
                                <span class="text-gray-500">Ongkos Kirim (Flat)</span>
                                <span class="font-bold text-gray-900">Rp {{ number_format($shippingFee, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="flex justify-between text-[16px] font-extrabold mb-8 border-t border-gray-100 pt-6">
                            <span class="text-gray-900">Total Pembayaran</span>
                            <span class="text-[#8C4A15] font-serif text-xl">Rp {{ number_format($total + $shippingFee, 0, ',', '.') }}</span>
                        </div>

                        <button type="submit" class="w-full bg-[#8C4A15] hover:bg-[#723C10] text-white py-4 rounded-xl text-[14px] font-bold transition-all shadow-[0_8px_16px_-6px_rgba(140,74,21,0.4)]">
                            Pesan Sekarang
                        </button>
                    </form>
                </div>
            </div>
        @else
            <div class="text-center py-20">
                <svg class="w-20 h-20 text-gray-300 mx-auto mb-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <h3 class="text-xl font-bold font-serif text-gray-900 mb-2">Your Cart is Empty</h3>
                <p class="text-gray-500 text-[14px] mb-6">Start exploring our menu and add your favorites!</p>
                <a href="{{ route('menu') }}" class="px-6 py-3 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold transition-colors inline-block">
                    Browse Menu
                </a>
            </div>
        @endif
    </div>
@endsection

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
            const latInput = document.getElementById('delivery_lat');
            const lngInput = document.getElementById('delivery_lng');
            const addressTextarea = document.getElementById('delivery_address');
            const addressSelect = document.getElementById('address_select');
            const manualSection = document.getElementById('manual_address_section');
            const btnLocation = document.getElementById('btn-my-location');

            // Initial Map Setup
            const map = L.map('map').setView([-6.200000, 106.816666], 13);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color:#8C4A15;width:24px;height:24px;border-radius:50%;border:3px solid white;box-shadow:0 4px 6px rgba(0,0,0,0.3); transform: translate(-12px, -12px);"></div>`,
                iconSize: [0, 0]
            });

            let marker = L.marker([-6.200000, 106.816666], {draggable: true, icon: customIcon}).addTo(map);

            // Map events
            marker.on('dragend', function(e) {
                if(addressSelect.value === 'manual') {
                    const pos = marker.getLatLng();
                    latInput.value = pos.lat;
                    lngInput.value = pos.lng;
                }
            });

            map.on('click', function(e) {
                if(addressSelect.value === 'manual') {
                    marker.setLatLng(e.latlng);
                    latInput.value = e.latlng.lat;
                    lngInput.value = e.latlng.lng;
                }
            });

            // Current Location Button
            btnLocation.addEventListener('click', function() {
                if ("geolocation" in navigator) {
                    btnLocation.innerHTML = 'Mencari lokasi...';
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        
                        map.setView([lat, lng], 16);
                        marker.setLatLng([lat, lng]);
                        latInput.value = lat;
                        lngInput.value = lng;
                        
                        btnLocation.innerHTML = '<svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg> Lokasi ditemukan!';
                    }, function(error) {
                        alert('Tidak dapat mengambil lokasi. Pastikan izin lokasi diaktifkan.');
                        btnLocation.innerHTML = 'Coba lagi';
                    });
                } else {
                    alert('Browser Anda tidak mendukung fitur lokasi.');
                }
            });

            // Address Dropdown Logic
            function updateAddressSource() {
                const selected = addressSelect.options[addressSelect.selectedIndex];
                
                if (addressSelect.value === 'manual') {
                    manualSection.classList.remove('hidden');
                    addressTextarea.required = true;
                    
                    // If map is shown for the first time, invalidate size to fix rendering
                    setTimeout(() => { map.invalidateSize(); }, 100);

                    // Use marker position
                    const pos = marker.getLatLng();
                    latInput.value = pos.lat;
                    lngInput.value = pos.lng;
                } else {
                    manualSection.classList.add('hidden');
                    addressTextarea.required = false;
                    
                    // Use selected option data
                    latInput.value = selected.dataset.lat;
                    lngInput.value = selected.dataset.lng;
                    addressTextarea.value = selected.dataset.full; // We submit this field implicitly or let controller handle it
                }
            }

            addressSelect.addEventListener('change', updateAddressSource);
            
            // Initial setup on load
            updateAddressSource();

            document.getElementById('checkoutForm').addEventListener('keypress', function(e) {
                if (e.key === 'Enter' && e.target.tagName !== 'TEXTAREA') {
                    e.preventDefault();
                }
            });
        });
    </script>
@endpush
