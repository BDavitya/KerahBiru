@extends('admin.layout')

@section('title', 'Tambah Worker')

@section('content')
    <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Tambah Mitra Pekerja</h2>
            <p class="text-gray-600 text-sm lg:text-base">Isi form berikut untuk mendaftarkan worker baru</p>
        </div>
        <a href="{{ route('admin.workers') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg transition text-sm lg:text-base">
            <i class="fa-solid fa-arrow-left mr-1 lg:mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 lg:p-8 border border-gray-200">
        <form action="{{ route('admin.workers.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6">

                {{-- Nama --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-solid fa-user-gear"></i> Nama</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('name') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- Pekerjaan --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-solid fa-briefcase"></i> Pekerjaan</label>
                    <input type="text" name="job_title" value="{{ old('job_title') }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('job_title') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- Gender --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-solid fa-person-half-dress"></i> Gender</label>
                    <select name="gender" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                        <option value="">Pilih</option>
                        <option {{ old('gender') == 'Laki-laki' ? 'selected' : '' }} value="Laki-laki">Laki-laki</option>
                        <option {{ old('gender') == 'Perempuan' ? 'selected' : '' }} value="Perempuan">Perempuan</option>
                    </select>
                    @error('gender') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- Harga --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-solid fa-coins"></i> Harga / Jam</label>
                    <input type="number" name="price_per_hour" value="{{ old('price_per_hour') }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base"
                        placeholder="50000">
                    @error('price_per_hour') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- Telepon --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-solid fa-phone"></i> Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('phone') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- WhatsApp --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                            class="fa-brands fa-whatsapp"></i> WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp') }}"
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-200 text-sm lg:text-base">
                    @error('whatsapp') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-4 lg:mt-6">
                <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                        class="fa-solid fa-align-left"></i> Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">{{ old('description') }}</textarea>
                @error('description') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
            </div>

            {{-- Foto --}}
            <div class="mt-4 lg:mt-6">
                <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base"><i
                        class="fa-solid fa-image"></i> Foto</label>
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                @error('photo') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
            </div>

            {{-- Maps --}}
            <div class="mt-4 lg:mt-6">
                <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                        class="fa-solid fa-map-marked-alt"></i> Pilih Lokasi di Peta</label>
                <p class="text-xs lg:text-sm text-gray-600 mb-3">Klik atau drag marker untuk memilih lokasi</p>
                <div id="map" style="height: 300px; border-radius: 8px;" class="border border-gray-300 lg:h-96"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 lg:gap-6 mt-4 lg:mt-6">
                {{-- Latitude --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base">Latitude</label>
                    <input type="number" id="latInput" name="latitude" step="any" value="{{ old('latitude', -7.7956) }}"
                        required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base"
                        readonly>
                    @error('latitude') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                {{-- Longitude --}}
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block text-sm lg:text-base">Longitude</label>
                    <input type="number" id="lngInput" name="longitude" step="any" value="{{ old('longitude', 110.3695) }}"
                        required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base"
                        readonly>
                    @error('longitude') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 lg:gap-4 mt-6 lg:mt-8">
                <button type="submit"
                    class="bg-[#052c62] hover:bg-[#031f46] text-white px-5 lg:px-6 py-2 lg:py-3 rounded-lg transition text-sm lg:text-base">
                    <i class="fa-solid fa-plus mr-1"></i> Tambah Worker
                </button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = {{ old('latitude', -7.7956) }};
        const lng = {{ old('longitude', 110.3695) }};

        const map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            document.getElementById('latInput').value = position.lat.toFixed(8);
            document.getElementById('lngInput').value = position.lng.toFixed(8);
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.getElementById('latInput').value = e.latlng.lat.toFixed(8);
            document.getElementById('lngInput').value = e.latlng.lng.toFixed(8);
        });
    </script>
@endsection