<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') | Dashboard Kerah Biru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/Icon.png') }}" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>

    <style>
        /* ============================================
           SIDEBAR STYLES
           ============================================ */
        .sidebar {
            background: #052c62;
            width: 260px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            display: flex;
            flex-direction: column;
            padding: 24px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
        }

        .sidebar-link {
            display: flex;
            gap: 12px;
            align-items: center;
            padding: 12px 16px;
            border-radius: 8px;
            color: #ffffffcc;
            transition: all 0.25s ease;
            text-decoration: none;
            font-size: 0.95rem;
        }

        .sidebar-link:hover {
            background: #ffffff22;
            color: white;
        }

        .sidebar-link.active {
            background: white !important;
            color: #052c62 !important;
            font-weight: 700;
        }

        .sidebar-link.active i {
            color: #052c62 !important;
        }

        .sidebar-link i {
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* LOGOUT SECTION */
        .logout-section {
            margin-top: auto;
            padding-top: 1rem;
        }

        .logout-btn {
            background: #dc2626;
            padding: 12px 16px;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            width: 100%;
            text-align: left;
            display: flex;
            gap: 10px;
            align-items: center;
            transition: all 0.25s ease;
            border: none;
            cursor: pointer;
        }

        .logout-btn:hover {
            background: #b91c1c;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 32px;
            min-height: 100vh;
            background: #f3f4f6;
        }

        /* ============================================
           PAGINATION STYLES - SIMPLE & CLEAN
           ============================================ */

        /* Active page (current page number) */
        nav[role="navigation"] span[aria-current="page"] {
            background-color: #052c62 !important;
            color: white !important;
            border-color: #052c62 !important;
            font-weight: 700 !important;
        }

        /* ============================================
           RESPONSIVE MOBILE
           ============================================ */
        @media (max-width: 1024px) {
            .sidebar {
                position: fixed;
                left: -280px;
                width: 260px;
                z-index: 999;
                transition: left 0.3s ease;
                box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0 !important;
                padding: 16px;
            }

            .mobile-overlay {
                display: none;
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }

            .mobile-overlay.active {
                display: block;
            }
        }

        @media (max-width: 640px) {
            .main-content {
                padding: 12px;
            }

            .sidebar {
                width: 240px;
                left: -260px;
            }
        }

        /* ============================================
           SCROLLBAR CUSTOM
           ============================================ */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* ============================================
   PAGINATION STYLES - FORCE OVERRIDE
   ============================================ */

        /* Override semua background gelap */
        nav[role="navigation"] * {
            background-image: none !important;
        }

        /* Base untuk semua item */
        nav[role="navigation"] span,
        nav[role="navigation"] a {
            background-color: #ffffff !important;
            color: #052c62 !important;
            border: 1px solid #d1d5db !important;
        }

        /* Active page */
        nav[role="navigation"] span[aria-current="page"] {
            background-color: #052c62 !important;
            color: #ffffff !important;
            border-color: #052c62 !important;
            font-weight: 700 !important;
        }

        /* Disabled */
        nav[role="navigation"] span[aria-disabled="true"] {
            background-color: #f3f4f6 !important;
            color: #9ca3af !important;
            border-color: #e5e7eb !important;
        }

        /* Hover */
        nav[role="navigation"] a:hover {
            background-color: #f3f4f6 !important;
        }
    </style>
</head>

<body class="bg-gray-100">


    <aside class="sidebar text-white">


        <div class="flex items-center gap-3 mb-6">
            <img src="{{ asset('images/Icon.png') }}" class="w-10">
            <h2 class="text-lg font-bold">Admin Kerah Biru</h2>
        </div>

        <hr class="border-white/30 mb-4">


        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}"
                class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-chart-line w-5"></i> Dashboard
            </a>

            <a href="{{ route('admin.users') }}"
                class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i> Pengguna
            </a>

            <a href="{{ route('admin.workers') }}"
                class="sidebar-link {{ request()->routeIs('admin.workers*') || request()->routeIs('admin.schedules*') ? 'active' : '' }}">
                <i class="fas fa-helmet-safety w-5"></i> Mitra Pekerja
            </a>

            <a href="{{ route('admin.orders') }}"
                class="sidebar-link {{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                <i class="fas fa-cart-shopping w-5"></i> Pesanan
            </a>
        </nav>


        <div class="logout-section">
            <form id="logoutForm" action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="button" onclick="confirmLogout()" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </button>
            </form>
        </div>

    </aside>


    <main class="main-content">

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Konfirmasi Logout',
                text: 'Apakah Anda yakin ingin keluar?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Keluar',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        }
    </script>

</body>

</html>