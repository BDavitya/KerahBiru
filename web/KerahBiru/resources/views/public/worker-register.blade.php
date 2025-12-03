<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pekerja | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />


    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet">


    <link rel="stylesheet" href="{{ asset('css/public.css') }}">

</head>

<body style="font-family: 'Montserrat', sans-serif; background-color: #f6f8fc">


    <nav class="navbar navbar-expand-lg fixed-top glass-navbar shadow-sm">
        <a class="navbar-brand fw-bold" href="{{ route('welcome') }}" style="color: #052c62">
            <img src="{{ asset('images/Icon.png') }}" alt="Logo Kerah Biru" height="50"> Kerah Biru
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li><a class="nav-link " href="{{ route('welcome') }}">Beranda</a></li>
                <li><a class="nav-link active" href="{{ route('worker.register.form') }}">Bergabung Menjadi Mitra</a>
                </li>
            </ul>
        </div>
    </nav>


    <div class="container py-5 mt-5">
        <div class="row justify-content-center align-items-center">


            <div class="col-lg-7">
                <div class="card border-0 shadow-sm p-4">


                    <div class="text-center mb-4">
                        <h2 class="fw-bold" style="color:#052c62;">Daftar Sebagai Mitra Pekerja</h2>
                        <p class="text-muted">Isi data diri Anda dengan benar untuk mulai bekerja</p>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success rounded-3">
                            <strong>Berhasil!</strong> {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('worker.register') }}" method="POST" enctype="multipart/form-data">
                        @csrf


                        <h5 class="text-dark fw-bold">Informasi Pribadi</h5>
                        <hr>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Nama Lengkap *</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Kelamin *</label>
                                <select name="gender" class="form-select" required>
                                    <option value="">Pilih</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                                @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">No. Telepon *</label>
                                <input type="text" name="phone" class="form-control" required>
                                @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">WhatsApp (Opsional)</label>
                                <input type="text" name="whatsapp" class="form-control">
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Foto Profil</label>
                                <input type="file" name="photo" class="form-control" required>
                                <small class="text-muted">*Max 5MB</small>
                            </div>
                        </div>


                        <h5 class="text-dark fw-bold mt-4">Informasi Pekerjaan</h5>
                        <hr>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Jenis Pekerjaan *</label>
                                <input type="text" name="job_title" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Harga per Jam (Rp) *</label>
                                <input type="number" name="price_per_hour" class="form-control" required>
                            </div>

                            <div class="col-12">
                                <label class="form-label fw-semibold">Deskripsi Keahlian *</label>
                                <textarea name="description" class="form-control" rows="3"
                                    placeholder="Ceritakan sedikit tentang pengalaman Anda..." required></textarea>
                            </div>
                        </div>


                        <h5 class="text-dark fw-bold mt-4">Lokasi</h5>
                        <hr>

                        <p class="small text-muted mb-3">Klik atau drag marker pada peta untuk memilih lokasi Anda</p>
                        <div id="map" style="height: 350px; border-radius: 8px;" class="border mb-3"></div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Latitude</label>
                                <input type="number" step="any" id="latInput" name="latitude" class="form-control"
                                    value="-7.7956" required readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Longitude</label>
                                <input type="number" step="any" id="lngInput" name="longitude" class="form-control"
                                    value="110.3695" required readonly>
                            </div>
                        </div>


                        <button class="btn btn-navy w-100 rounded-pill py-2 fw-semibold">
                            <i class="bi bi-person-plus me-2"></i>Bergabung Sekarang
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-block text-center">
                <img src="{{ asset('images/Worker.png') }}" class="img-fluid" alt="Worker">
            </div>
        </div>
    </div>


    <footer class="text-center py-2 text-white" style="background:#052c62;">
        <small>Copyright © 2025 Kerah Biru</small>
    </footer>



    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        const lat = -7.7956;
        const lng = 110.3695;

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>