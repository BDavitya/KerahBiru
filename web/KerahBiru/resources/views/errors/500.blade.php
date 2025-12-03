<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>500 - Terjadi Kesalahan | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes shake {

            0%,
            100% {
                transform: rotate(0deg);
            }

            10%,
            30%,
            50%,
            70%,
            90% {
                transform: rotate(-5deg);
            }

            20%,
            40%,
            60%,
            80% {
                transform: rotate(5deg);
            }
        }

        .shake-animation {
            animation: shake 1s ease-in-out infinite;
        }
    </style>
</head>

<body class="bg-gradient-to-br from-red-50 to-orange-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Icon -->
        <div class="shake-animation mb-8 inline-block">
            <i class="fas fa-server text-8xl md:text-9xl text-red-400 opacity-80"></i>
        </div>

        <!-- Error Code -->
        <h1 class="text-7xl md:text-9xl font-bold text-gray-800 mb-4">500</h1>

        <!-- Message -->
        <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-4">
            Terjadi Kesalahan Server
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8 px-4">
            Maaf, terjadi kesalahan pada server kami.
            Tim teknis kami telah diberitahu dan sedang menangani masalah ini.
        </p>

        <!-- Error Details (Only in development) -->
        @if(config('app.debug') && isset($exception))
            <div class="bg-red-100 border border-red-300 rounded-lg p-4 mb-8 text-left max-w-xl mx-auto">
                <h3 class="font-bold text-red-800 mb-2 flex items-center">
                    <i class="fas fa-bug mr-2"></i>
                    Detail Error (Development Mode)
                </h3>
                <p class="text-red-700 text-sm break-all">
                    <strong>Message:</strong> {{ $exception->getMessage() }}
                </p>
                <p class="text-red-700 text-sm mt-2 break-all">
                    <strong>File:</strong> {{ $exception->getFile() }}:{{ $exception->getLine() }}
                </p>
            </div>
        @endif

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center px-4">
            <button onclick="location.reload()"
                class="inline-flex items-center justify-center px-6 py-3 bg-orange-600 hover:bg-orange-700 text-white rounded-lg transition duration-300 shadow-lg">
                <i class="fas fa-refresh mr-2"></i>
                Muat Ulang
            </button>

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
            <p class="mb-2">Jika masalah terus berlanjut, silakan hubungi:</p>
            <a href="https://wa.me/6281212330404" target="_blank"
                class="text-green-600 hover:text-green-700 font-semibold">
                <i class="fab fa-whatsapp mr-1"></i>
                +62 812 1233 0404
            </a>
        </div>
    </div>
</body>

</html>