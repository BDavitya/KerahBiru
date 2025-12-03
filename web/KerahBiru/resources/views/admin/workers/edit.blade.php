@extends('admin.layout')

@section('title', 'Edit Pekerja')

@section('content')
    <div class="mb-8">
        <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Perbarui Data Pekerja</h2>
        <p class="text-gray-600 text-sm lg:text-base">Silahkan ubah informasi pekerja di bawah ini</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 lg:p-8 border border-gray-200">
        <form action="{{ route('admin.workers.update', $worker->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $worker->name) }}" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('name') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Pekerjaan</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $worker->job_title) }}" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('job_title') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Jenis Kelamin</label>
                    <select name="gender" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                        <option value="">Pilih</option>
                        <option value="Laki-laki" @selected($worker->gender == 'Laki-laki')>Laki-laki</option>
                        <option value="Perempuan" @selected($worker->gender == 'Perempuan')>Perempuan</option>
                    </select>
                    @error('gender') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Harga per Jam (Rp)</label>
                    <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $worker->price_per_hour) }}"
                        required class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('price_per_hour') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Nomor Telepon</label>
                    <input type="text" name="phone" value="{{ old('phone', $worker->phone) }}" required
                        class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('phone') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $worker->whatsapp) }}"
                        class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('whatsapp') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Latitude</label>
                    <input type="number" step="any" name="latitude" value="{{ old('latitude', $worker->latitude) }}"
                        required class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('latitude') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>

                <div>
                    <label class="font-semibold text-[#052c62] mb-2 block">Longitude</label>
                    <input type="number" step="any" name="longitude" value="{{ old('longitude', $worker->longitude) }}"
                        required class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                    @error('longitude') <small class="text-red-500">{{ $message }}</small> @enderror
                </div>
            </div>

            <div class="mt-6">
                <label class="font-semibold text-[#052c62] mb-2 block">Deskripsi</label>
                <textarea name="description" rows="4"
                    class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">{{ old('description', $worker->description) }}</textarea>
                @error('description') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>

            <div class="mt-6">
                <div id="map" style="height: 400px; border-radius: 8px;" class="border border-gray-300"></div>
            </div>

            <div class="mt-6">
                <label class="font-semibold text-[#052c62] mb-2 block">Foto</label>
                @if($worker->photo)
                    <img src="{{ asset('storage/' . $worker->photo) }}" class="w-28 h-28 rounded-lg object-cover mb-3">
                @endif
                <input type="file" name="photo" accept="image/*"
                    class="w-full px-4 py-3 border rounded-lg focus:ring focus:ring-blue-300">
                @error('photo') <small class="text-red-500">{{ $message }}</small> @enderror
            </div>

            <div class="flex flex-col sm:flex-row justify-end gap-4 mt-8">
                <a href="{{ route('admin.workers') }}"
                    class="text-center bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg">
                    <i class="fa-solid fa-arrow-left"></i> Batal
                </a>
                <button type="submit" class="bg-[#052c62] hover:bg-[#031f46] text-white px-6 py-3 rounded-lg transition">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan
                </button>
            </div>
        </form>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = {{ $worker->latitude }};
        const lng = {{ $worker->longitude }};

        const map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        let marker = L.marker([lat, lng], { draggable: true }).addTo(map);

        marker.on('dragend', function (e) {
            const position = marker.getLatLng();
            document.querySelector('input[name="latitude"]').value = position.lat;
            document.querySelector('input[name="longitude"]').value = position.lng;
        });

        map.on('click', function (e) {
            marker.setLatLng(e.latlng);
            document.querySelector('input[name="latitude"]').value = e.latlng.lat;
            document.querySelector('input[name="longitude"]').value = e.latlng.lng;
        });
    </script>
@endsection