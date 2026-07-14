@extends('customer.account-layout')

@section('title', isset($address) ? 'Edit Alamat' : 'Tambah Alamat')

@section('account_content')
    <div class="bg-white rounded-2xl p-6 md:p-8 shadow-sm border border-[#EBE1D7]">
        <a href="{{ route('customer.addresses.index') }}" class="inline-flex items-center gap-2 text-[13px] font-bold text-gray-500 hover:text-[#8C4A15] transition-colors mb-6">
            <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali ke Buku Alamat
        </a>

        <div class="bg-white rounded-3xl border border-[#EBE1D7] shadow-sm overflow-hidden p-6 md:p-8">
            <h1 class="text-2xl font-extrabold font-serif text-gray-900 mb-8">{{ isset($address) ? 'Edit Alamat' : 'Tambah Alamat Baru' }}</h1>

            <form action="{{ isset($address) ? route('customer.addresses.update', $address) : route('customer.addresses.store') }}" method="POST">
                @csrf
                @if(isset($address))
                    @method('PUT')
                @endif

                <div class="space-y-6">
                    {{-- Label --}}
                    <div>
                        <label for="label" class="block text-[13px] font-bold text-gray-700 mb-2">Label Alamat (Contoh: Rumah, Kantor)</label>
                        <input type="text" id="label" name="label" value="{{ old('label', $address->label ?? '') }}" required
                               class="w-full h-12 px-4 rounded-xl border border-[#EBE1D7] bg-[#FCF8F2] text-[14px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] transition-colors">
                        @error('label')
                            <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address Detail --}}
                    <div>
                        <label for="full_address" class="block text-[13px] font-bold text-gray-700 mb-2">Alamat Lengkap</label>
                        <textarea id="full_address" name="full_address" rows="3" required
                                  class="w-full px-4 py-3 rounded-xl border border-[#EBE1D7] bg-[#FCF8F2] text-[14px] focus:ring-1 focus:ring-[#8C4A15] focus:border-[#8C4A15] transition-colors resize-none">{{ old('full_address', $address->full_address ?? '') }}</textarea>
                        @error('full_address')
                            <p class="text-red-500 text-[12px] mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Map Picker --}}
                    <div>
                        <label class="block text-[13px] font-bold text-gray-700 mb-2">Pin Lokasi Pengiriman</label>
                        <p class="text-[12px] text-gray-500 mb-3">Geser pin pada peta untuk menentukan lokasi persis pengiriman Anda.</p>
                        
                        <div id="map" class="w-full h-[300px] rounded-xl border border-[#EBE1D7] mb-3 z-10 relative"></div>
                        
                        <input type="hidden" id="lat" name="lat" value="{{ old('lat', $address->lat ?? '-6.1753924') }}">
                        <input type="hidden" id="lng" name="lng" value="{{ old('lng', $address->lng ?? '106.8271528') }}">
                    </div>

                    {{-- Set Default --}}
                    @if(!isset($address) || !$address->is_default)
                        <div class="flex items-center gap-3 p-4 bg-[#FCF8F2] rounded-xl border border-[#EBE1D7]">
                            <input type="checkbox" id="is_default" name="is_default" value="1" {{ old('is_default') ? 'checked' : '' }}
                                   class="w-5 h-5 text-[#8C4A15] rounded border-gray-300 focus:ring-[#8C4A15]">
                            <label for="is_default" class="text-[14px] font-bold text-gray-700 cursor-pointer">Jadikan Alamat Utama</label>
                        </div>
                    @endif

                    <button type="submit" class="w-full py-4 bg-[#8C4A15] hover:bg-[#723C10] text-white rounded-xl text-[14px] font-bold transition-all shadow-md">
                        Simpan Alamat
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" crossorigin=""/>
    <style>
        .leaflet-container { font-family: 'Inter', sans-serif; }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const latInput = document.getElementById('lat');
            const lngInput = document.getElementById('lng');
            
            const initialLat = parseFloat(latInput.value) || -6.1753924;
            const initialLng = parseFloat(lngInput.value) || 106.8271528;

            const map = L.map('map').setView([initialLat, initialLng], 15);
            L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            const customIcon = L.divIcon({
                className: 'custom-div-icon',
                html: `<div style="background-color:#8C4A15;width:24px;height:24px;border-radius:50%;border:3px solid white;box-shadow:0 4px 6px rgba(0,0,0,0.3); transform: translate(-12px, -12px);"></div>`,
                iconSize: [0, 0]
            });

            let marker = L.marker([initialLat, initialLng], {
                draggable: true,
                icon: customIcon
            }).addTo(map);

            marker.on('dragend', function(e) {
                const pos = marker.getLatLng();
                latInput.value = pos.lat.toFixed(7);
                lngInput.value = pos.lng.toFixed(7);
            });

            // If user clicks on map, move marker
            map.on('click', function(e) {
                marker.setLatLng(e.latlng);
                latInput.value = e.latlng.lat.toFixed(7);
                lngInput.value = e.latlng.lng.toFixed(7);
            });
            
            // Try geolocation if adding new
            @if(!isset($address) && !old('lat'))
                if ("geolocation" in navigator) {
                    navigator.geolocation.getCurrentPosition(function(position) {
                        const userLat = position.coords.latitude;
                        const userLng = position.coords.longitude;
                        map.setView([userLat, userLng], 15);
                        marker.setLatLng([userLat, userLng]);
                        latInput.value = userLat.toFixed(7);
                        lngInput.value = userLng.toFixed(7);
                    });
                }
            @endif
        });
    </script>
@endpush
