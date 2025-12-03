<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-blue-50 to-indigo-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Icon -->
        <div class="float-animation mb-8">
            <i class="fas fa-search text-8xl md:text-9xl text-blue-400 opacity-80"></i>
        </div>

        <!-- Error Code -->
        <h1 class="text-7xl md:text-9xl font-bold text-gray-800 mb-4">404</h1>

        <!-- Message -->
        <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-4">
            Halaman Tidak Ditemukan
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8 px-4">
            Maaf, halaman yang Anda cari tidak dapat ditemukan.
            Mungkin halaman tersebut telah dipindahkan atau dihapus.
        </p>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center px-4">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition duration-300 shadow-lg">
                <i class="fas fa-arrow-left mr-2"></i>
                Kembali
            </a>

            <a href="{{ route('welcome') }}"
                class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition duration-300 shadow-lg">
                <i class="fas fa-home mr-2"></i>
                Halaman Utama
            </a>

            @if(session('admin_logged_in'))
                <a href="{{ route('admin.dashboard') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-300 shadow-lg">
                    <i class="fas fa-dashboard mr-2"></i>
                    Dashboard
                </a>
            @endif
        </div>

        <!-- Additional Info -->
        <div class="mt-12 text-gray-500 text-sm">
            <p>Jika Anda yakin ini adalah kesalahan, silakan hubungi administrator.</p>
        </div>
    </div>
</body>

</html>