@extends('admin.layout')

@section('title', 'Edit Pengguna')

@section('content')
    <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Perbarui Data Pengguna</h2>
            <p class="text-gray-600 text-sm lg:text-base">Silahkan ubah informasi pengguna di bawah ini</p>
        </div>
        <a href="{{ route('admin.users') }}"
            class="bg-gray-500 hover:bg-gray-600 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg transition text-sm lg:text-base">
            <i class="fa-solid fa-arrow-left mr-1 lg:mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white rounded-lg shadow-md p-4 lg:p-8 border border-gray-200">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                            class="fa-solid fa-user"></i> Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('name') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                            class="fa-solid fa-envelope"></i> Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('email') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                            class="fa-solid fa-phone"></i> Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">
                    @error('phone') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                            class="fa-solid fa-image"></i> Foto Profil</label>
                    @if($user->photo)
                        <img src="{{ asset('storage/' . $user->photo) }}"
                            class="w-16 h-16 lg:w-20 lg:h-20 rounded-full mb-3 object-cover">
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-200 text-sm lg:text-base">
                    @error('photo') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-4 lg:mt-6">
                <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                        class="fa-solid fa-map-location-dot"></i> Alamat</label>
                <textarea name="address" rows="3"
                    class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base">{{ old('address', $user->address) }}</textarea>
                @error('address') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
            </div>

            <div class="mt-4 lg:mt-6">
                <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base"><i
                        class="fa-solid fa-location-dot"></i> Pilih Lokasi di Peta</label>
                <p class="text-xs lg:text-sm text-gray-600 mb-3">Klik atau drag marker untuk memilih lokasi</p>
                <div id="map" style="height: 300px; border-radius: 8px;" class="border border-gray-300 lg:h-96"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6 mt-4 lg:mt-6">
                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base">Latitude</label>
                    <input type="number" step="any" id="latInput" name="latitude"
                        value="{{ old('latitude', $user->latitude) }}"
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base"
                        readonly>
                    @error('latitude') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="block font-semibold text-[#052c62] mb-2 text-sm lg:text-base">Longitude</label>
                    <input type="number" step="any" id="lngInput" name="longitude"
                        value="{{ old('longitude', $user->longitude) }}"
                        class="w-full px-3 lg:px-4 py-2 lg:py-3 border rounded-lg focus:ring focus:ring-blue-300 text-sm lg:text-base"
                        readonly>
                    @error('longitude') <small class="text-red-500 text-xs">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="flex justify-end gap-3 lg:gap-4 mt-6 lg:mt-8">
                <button type="submit"
                    class="bg-[#052c62] hover:bg-[#031f46] text-white px-5 lg:px-6 py-2 lg:py-3 rounded-lg transition text-sm lg:text-base">
                    <i class="fa-solid fa-floppy-disk mr-1"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = {{ $user->latitude ?? -7.7956 }};
        const lng = {{ $user->longitude ?? 110.3695 }};

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