<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Platform Insan Karya Raga | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />


    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&display=swap" rel="stylesheet" />


    <link rel="stylesheet" href="{{ asset('css/public.css') }}">

    <style>
        .worker-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .worker-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }

        .testimonial-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .star-rating {
            color: #ffc107;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg fixed-top glass-navbar shadow-sm">
        <a class="navbar-brand fw-bold" href="{{ route('welcome') }}" style="color: #052c62">
            <img src="{{ asset('images/Icon.png') }}" alt="Logo Kerah Biru" height="50"> Kerah Biru
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <i class="bi bi-list fs-2"></i>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav gap-3">
                <li><a class="nav-link active" href="{{ route('welcome') }}">Beranda</a></li>
                <li><a class="nav-link" href="{{ route('worker.register.form') }}">Bergabung Menjadi Mitra</a></li>
            </ul>
        </div>
    </nav>


    <section id="hero" class="hero d-flex align-items-center text-light" style="
        min-height: 95vh;
        background-color: #6980a1;
        border-radius: 0 0 75px 75px;
        margin: 0px 10px 10px;
        overflow: hidden;
    ">
        <div class="container-fluid">
            <div class="row gx-0 h-100 d-flex align-items-center">
                <div class="col-md-4 d-none d-md-flex justify-content-center">
                    <img src="{{ asset('images/Worker.png') }}" class="img-fluid" style="max-height:40rem;"
                        alt="Worker Image">
                </div>
                <div class="col-md-8 d-flex align-items-center justify-content-center p-4 p-md-5">
                    <div class="text-start">
                        <h1 class="fw-bold display-4 mb-3">
                            Platform Insan Karya Raga
                        </h1>
                        <p class="lead mb-4">
                            <span class="align-items-center text-primary-emphasis fw-bold">
                                <img src="{{ asset('images/Icon.png') }}" style="width: 2rem;" />
                                Kerah Biru </span>
                            menghadirkan akses kerja yang adil, layak, dan transparan bagi para pekerja fisik di
                            Indonesia — sembari
                            membantu masyarakat mendapatkan layanan jasa terpercaya kapan saja.
                        </p>
                        <a href="{{ route('worker.register.form') }}"
                            class="btn btn-navy btn-lg rounded-pill px-4 fw-semibold">
                            Bergabung Bersama Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section id="intro" class="pt-5">
        <div class="container text-center border-bottom pb-4">
            <h5 class="mb-4 px-3">
                <span class="align-items-center text-primary-emphasis fw-bold">
                    <img src="{{ asset('images/Icon.png') }}" style="width: 2rem;" />
                    Kerah Biru</span> adalah platform digital yang menghubungkan pekerja fisik dengan
                pelanggan secara cepat, aman, dan transparan.
                Kami percaya setiap pekerja memiliki hak untuk tetap produktif dan mendapatkan kesempatan kerja tanpa
                batasan usia maupun latar belakang pendidikan.
            </h5>
        </div>
    </section>


    <section class="py-5" id="history">
        <div class="container text-center pb-4 border-bottom">
            <h2 class="fw-bold mb-3" style="color: #052c62;">Perkembangan Kami</h2>
            <p class="text-muted">Jejak nyata <span class="align-items-center text-primary-emphasis fw-bold">
                    <img src="{{ asset('images/Icon.png') }}" style="width: 2rem;" />
                    Kerah Biru </span>dalam membangun ekosistem kerja yang inklusif</p>

            <div class="d-flex flex-wrap justify-content-center position-relative">
                <div class="text-center position-relative p-3" style="flex:1 1 250px;">
                    <div class="rounded-circle bg-primary mx-auto mb-3" style="width:30px; height:30px;"></div>
                    <div class="p-4 bg-white rounded shadow hover-shadow">
                        <h5 class="fw-bold text-primary">2019</h5>
                        <p class="small text-muted mb-0">
                            Riset kebutuhan pekerja lepas dan masyarakat perkotaan dimulai.
                        </p>
                    </div>
                </div>
                <div class="text-center position-relative p-3" style="flex:1 1 250px;">
                    <div class="rounded-circle bg-success mx-auto mb-3" style="width:30px; height:30px;"></div>
                    <div class="p-4 bg-white rounded hover-shadow shadow">
                        <h5 class="fw-bold text-success">2020</h5>
                        <p class="small text-muted mb-0">
                            Pengembangan sistem pemesanan jasa berbasis digital mulai dirancang.
                        </p>
                    </div>
                </div>
                <div class="text-center position-relative p-3" style="flex:1 1 250px;">
                    <div class="rounded-circle bg-warning mx-auto mb-3" style="width:30px; height:30px;"></div>
                    <div class="p-4 bg-white rounded hover-shadow shadow">
                        <h5 class="fw-bold text-warning">2021</h5>
                        <p class="small text-muted mb-0">
                            Program percontohan layanan pekerja fisik diluncurkan di beberapa wilayah.
                        </p>
                    </div>
                </div>
                <div class="text-center position-relative p-3" style="flex:1 1 250px;">
                    <div class="rounded-circle bg-danger mx-auto mb-3" style="width:30px; height:30px;"></div>
                    <div class="p-4 bg-white rounded hover-shadow shadow">
                        <h5 class="fw-bold text-danger">2022</h5>
                        <p class="small text-muted mb-0">
                            <span class="align-items-center text-primary-emphasis fw-bold">
                                <img src="{{ asset('images/Icon.png') }}" style="width: 1rem;" />
                                Kerah Biru</span> dikembangkan menjadi platform penuh dengan fitur rating, pembayaran
                            aman, dan verifikasi pekerja.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-4 container" id="vision-mission">
        <div class="row align-items-start position-relative">

            <div class="col-md-5 mb-4 mb-md-0">
                <h2 class="fw-bold mb-3" style="color: #052c62;">Visi Kami</h2>
                <p class="text-muted">
                    Menjadi platform tenaga kerja fisik terdepan di Indonesia
                    yang memberikan kesempatan kerja layak dan meningkatkan taraf hidup masyarakat.
                </p>
            </div>

            <div class="divider-line d-none d-md-block"></div>

            <div class="col-md-7">
                <h2 class="fw-bold mb-3" style="color: #052c62;">Misi Kami</h2>
                <ul class="fs-6 text-muted">
                    <li>Meningkatkan akses pekerjaan bagi pekerja fisik tanpa batasan usia.</li>
                    <li>Membantu masyarakat mendapatkan layanan jasa yang profesional dan terpercaya.</li>
                    <li>Menyediakan sistem pencocokan kerja yang adil berbasis rating dan ulasan.</li>
                    <li>Menjamin keamanan transaksi melalui pembayaran digital yang transparan.</li>
                    <li>Mendukung pemberdayaan ekonomi masyarakat melalui teknologi.</li>
                </ul>
            </div>
        </div>
    </section>


    <section class="py-5 bg-light" id="advantages">
        <div class="container">
            <div class="row align-items-center g-4">
                <div class="col-md-12 col-lg-3 mb-4 mb-lg-0">
                    <h2 class="fw-bold mb-3" style="color: #052c62;">
                        Kenapa Kami?
                    </h2>
                    <p class="text-muted mb-4">
                        Kami tak hanya menghubungkan — kami memberdayakan
                    </p>
                </div>
                <div class="col-md-12 col-lg-9">
                    <div class="row g-4">
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-shadow text-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center rounded-circle bg-primary text-white mx-auto mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-people fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Akses Kerja Inklusif</h5>
                                <p class="text-muted small">
                                    Kesempatan untuk bekerja tanpa diskriminasi usia dan latar belakang.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-shadow text-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center rounded-circle bg-success text-white mx-auto mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-clock fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Layanan yang Fleksibel</h5>
                                <p class="text-muted small">
                                    Pekerja bebas memilih waktu dan jenis pekerjaan sesuai kemampuan.
                                </p>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 border-0 shadow-sm p-4 hover-shadow text-center">
                                <div class="icon-circle d-flex align-items-center justify-content-center rounded-circle bg-warning text-white mx-auto mb-3"
                                    style="width: 70px; height: 70px;">
                                    <i class="bi bi-search fs-3"></i>
                                </div>
                                <h5 class="fw-bold">Cepat & Tepat</h5>
                                <p class="text-muted small">
                                    Menemukan pekerja sesuai lokasi, tarif, dan keahlian.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <section class="py-5" id="workers">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #052c62;">Mitra Pekerja Kami</h2>
                <p class="text-muted">Dipercaya oleh berbagai pekerja profesional dan berpengalaman</p>
            </div>

            <div class="row g-4">
                @php
                    $topWorkers = \App\Models\Worker::where('approval_status', 'approved')
                        ->where('total_orders', '>', 0)
                        ->orderBy('rating', 'desc')
                        ->take(6)
                        ->get();
                @endphp

                @forelse($topWorkers as $worker)
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="card worker-card border-0 shadow-sm h-100 text-center p-3">
                            @if($worker->photo)
                                <img src="{{ asset('storage/' . $worker->photo) }}" class="rounded-circle mx-auto mb-3"
                                    style="width: 80px; height: 80px; object-fit: cover;" alt="{{ $worker->name }}">
                            @else
                                <div class="rounded-circle mx-auto mb-3 bg-primary text-white d-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px;">
                                    <span class="fw-bold fs-3">{{ substr($worker->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <h6 class="fw-bold mb-1">{{ $worker->name }}</h6>
                            <p class="text-muted small mb-2">{{ $worker->job_title }}</p>
                            <div class="star-rating small">
                                <i class="bi bi-star-fill"></i> {{ number_format($worker->rating, 1) }}
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <p>Belum ada mitra pekerja terdaftar</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <section class="py-5 bg-light" id="testimonials">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #052c62;">Rating & Ulasan Pelanggan</h2>
                <p class="text-muted">Apa kata pengguna tentang layanan kami</p>
            </div>

            <div class="row g-4">
                @php
                    $reviews = \App\Models\Order::whereNotNull('user_review')
                        ->whereNotNull('user_rating')
                        ->with(['user', 'worker'])
                        ->orderBy('created_at', 'desc')
                        ->take(6)
                        ->get();
                @endphp

                @forelse($reviews as $review)
                    <div class="col-md-6 col-lg-4">
                        <div class="testimonial-card">
                            <div class="d-flex align-items-center mb-3">
                                @if($review->user->photo)
                                    <img src="{{ asset('storage/' . $review->user->photo) }}" class="rounded-circle me-3"
                                        style="width: 50px; height: 50px; object-fit: cover;" alt="{{ $review->user->name }}">
                                @else
                                    <div class="rounded-circle me-3 bg-primary text-white d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <span class="fw-bold">{{ substr($review->user->name, 0, 1) }}</span>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mb-0 fw-bold">{{ $review->user->name }}</h6>
                                    <div class="star-rating small">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->user_rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-muted small mb-2">"{{ $review->user_review }}"</p>
                            <p class="text-muted small mb-0">
                                <strong>Pekerja:</strong> {{ $review->worker->name }} ({{ $review->worker->job_title }})
                            </p>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted py-5">
                        <p>Belum ada ulasan dari pelanggan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>


    <section class="py-5" id="contact">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" style="color: #052c62;">Hubungi Kami</h2>
                <p class="text-muted px-3">Mari berkolaborasi bersama dalam membangun masa depan kerja yang lebih
                    inklusif
                    dan sejahtera bagi para pekerja Indonesia.</p>
            </div>

            <div class="row g-4 align-items-center">

                <div class="col-md-6">
                    <div class="card border-0 shadow-sm p-4 h-100">
                        <ul class="list-unstyled mb-4">
                            <li class="mb-3">
                                <i class="bi bi-geo-alt-fill me-2"></i>
                                <strong>Alamat:</strong> Jl. Mampang Prapatan Raya, Jakarta Selatan 12790
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-telephone-fill me-2"></i>
                                <strong>HP:</strong>
                                <a href="https://wa.me/6281212330404" target="_blank" class="text-decoration-none">
                                    +62 812 1233 0404
                                </a>
                            </li>
                            <li class="mb-3">
                                <i class="bi bi-envelope-fill me-2"></i>
                                <strong>Email:</strong> info@kerahbiru.com
                            </li>
                            <li>
                                <i class="bi bi-printer-fill me-2"></i>
                                <strong>Fax:</strong> 021 5098 3829
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="ratio ratio-16x9 shadow-sm rounded">
                        <div style="width: 100%"><iframe width="100%" height="100%" frameborder="0" scrolling="no"
                                marginheight="0" marginwidth="0"
                                src="https://maps.google.com/maps?width=100%25&amp;height=200&amp;hl=en&amp;q=Jl.%20Mampang%20Prapatan%20Raya,%20No.%2073A%20Lantai%203,%20Jakarta%20Selatan%2012790+(Camp%20404)&amp;t=&amp;z=14&amp;ie=UTF8&amp;iwloc=B&amp;output=embed"></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <footer class="text-center py-2 text-white" style="background: #052c62;">
        <i class="opacity-75 small">Copyright &copy; 2025</i>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
</body>

</html>