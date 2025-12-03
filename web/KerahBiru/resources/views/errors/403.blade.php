<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Akses Ditolak | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.05);
                opacity: 0.8;
            }
        }

        .pulse-animation {
            animation: pulse 2s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-yellow-50 to-red-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Icon -->
        <div class="pulse-animation mb-8 inline-block">
            <i class="fas fa-lock text-8xl md:text-9xl text-yellow-500 opacity-80"></i>
        </div>

        <!-- Error Code -->
        <h1 class="text-7xl md:text-9xl font-bold text-gray-800 mb-4">403</h1>

        <!-- Message -->
        <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-4">
            Akses Ditolak
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8 px-4">
            Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.
            Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
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

            @if(!session('admin_logged_in'))
                <a href="{{ route('admin.login') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition duration-300 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Login Admin
                </a>
            @endif
        </div>

        <!-- Additional Info -->
        <div class="mt-12 text-gray-500 text-sm">
            <p class="mb-2">Butuh bantuan? Hubungi kami:</p>
            <a href="https://wa.me/6281212330404" target="_blank"
                class="text-green-600 hover:text-green-700 font-semibold">
                <i class="fab fa-whatsapp mr-1"></i>
                +62 812 1233 0404
            </a>
        </div>
    </div>
</body>

</html>