<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>503 - Sedang Maintenance | Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .spin-animation {
        animation: spin 3s linear infinite;
    }
    </style>
</head>

<body class="bg-gradient-to-br from-purple-50 to-blue-100 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full text-center">
        <!-- Icon -->
        <div class="spin-animation mb-8 inline-block">
            <i class="fas fa-tools text-8xl md:text-9xl text-purple-400 opacity-80"></i>
        </div>

        <!-- Error Code -->
        <h1 class="text-7xl md:text-9xl font-bold text-gray-800 mb-4">503</h1>

        <!-- Message -->
        <h2 class="text-2xl md:text-4xl font-bold text-gray-700 mb-4">
            Sedang Dalam Maintenance
        </h2>

        <p class="text-gray-600 text-base md:text-lg mb-8 px-4">
            Maaf, saat ini sistem kami sedang dalam pemeliharaan.
            Kami akan segera kembali online. Terima kasih atas kesabaran Anda.
        </p>

        <!-- Timer (optional) -->
        <div class="bg-white rounded-lg shadow-lg p-6 mb-8 max-w-md mx-auto">
            <p class="text-gray-700 font-semibold mb-2">Estimasi Selesai:</p>
            <p class="text-3xl font-bold text-purple-600">
                <i class="far fa-clock mr-2"></i>
                <span id="countdown">Loading...</span>
            </p>
        </div>

        <!-- Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center px-4">
            <button onclick="location.reload()"
                class="inline-flex items-center justify-center px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg transition duration-300 shadow-lg">
                <i class="fas fa-refresh mr-2"></i>
                Coba Lagi
            </button>

            <a href="https://wa.me/6281212330404" target="_blank"
                class="inline-flex items-center justify-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-300 shadow-lg">
                <i class="fab fa-whatsapp mr-2"></i>
                Hubungi Kami
            </a>
        </div>

        <!-- Additional Info -->
        <div class="mt-12 text-gray-500 text-sm">
            <p>Untuk informasi lebih lanjut, silakan hubungi tim support kami.</p>
        </div>
    </div>

    <script>
    // Simple countdown timer (example: 30 minutes)
    let timeLeft = 1800; // 30 minutes in seconds

    function updateCountdown() {
        const hours = Math.floor(timeLeft / 3600);
        const minutes = Math.floor((timeLeft % 3600) / 60);
        const seconds = timeLeft % 60;

        document.getElementById('countdown').textContent =
            `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

        if (timeLeft > 0) {
            timeLeft--;
            setTimeout(updateCountdown, 1000);
        } else {
            document.getElementById('countdown').textContent = 'Segera Online!';
            setTimeout(() => location.reload(), 2000);
        }
    }

    updateCountdown();
    </script>
</body>

</html>