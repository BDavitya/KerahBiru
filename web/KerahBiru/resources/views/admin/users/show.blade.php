@extends('admin.layout')

@section('title', 'Detail Pengguna')

@section('content')
    <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-3 lg:gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Detail Pengguna</h2>
            <p class="text-gray-600 text-sm lg:text-base">Informasi lengkap terkait pengguna yang terdaftar di Kerah Biru
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="bg-yellow-500 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg hover:bg-yellow-600 transition text-sm lg:text-base">
                <i class="fa-solid fa-pen-to-square"></i> Perbarui
            </a>
            <a href="{{ route('admin.users') }}"
                class="bg-gray-600 text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg hover:bg-gray-700 transition text-sm lg:text-base">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div>
            <div class="bg-white shadow-md p-6 rounded-lg">
                @if($user->photo)
                    <img src="{{ asset('storage/' . $user->photo) }}" class="w-full h-64 object-cover rounded-lg shadow">
                @else
                    <div class="w-full h-64 bg-[#052c62] rounded-lg flex items-center justify-center shadow">
                        <span class="text-7xl text-white font-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                    </div>
                @endif

                <h3 class="text-2xl font-bold text-center mt-4 text-[#052c62]">{{ $user->name }}</h3>
                <p class="text-center text-gray-600">{{ $user->email }}</p>

                <div class="flex justify-center mt-3">
                    @if($user->is_verified)
                        <span class="px-4 py-2 bg-green-100 text-green-700 rounded-full font-semibold text-sm">
                            <i class="fa-solid fa-circle-check"></i> Terverifikasi
                        </span>
                    @else
                        <span class="px-4 py-2 bg-yellow-100 text-yellow-800 rounded-full font-semibold text-sm">
                            <i class="fa-solid fa-clock"></i> Belum Terverifikasi
                        </span>
                    @endif
                </div>

                <div class="border-t mt-4 pt-3 text-center text-sm text-gray-600">
                    Bergabung sejak:
                    <span class="font-semibold text-gray-800">{{ $user->created_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>


        <div class="lg:col-span-2 space-y-6">


            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-address-book"></i> Informasi Kontak
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Email</p>
                        <p class="font-semibold">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        <p class="font-semibold">{{ $user->phone ?? '-' }}</p>
                    </div>
                    <div class="md:col-span-2">
                        <p class="text-gray-500">Alamat</p>
                        <p class="font-semibold">{{ $user->address ?? '-' }}</p>
                    </div>
                </div>
            </div>


            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-list-check"></i> Riwayat Pemesanan
                </h3>

                @forelse($user->orders->take(5) as $order)
                    <div
                        class="border-l-4 mb-3 p-3 shadow-sm rounded-md 
                                                                        {{ $order->status == 'completed' ? 'border-green-500' : 'border-yellow-500' }}">
                        <div class="flex justify-between text-sm">
                            <div>
                                <p class="font-semibold">{{ $order->worker->name }} - {{ $order->worker->job_title }}</p>
                                <p class="text-gray-500">
                                    {{ $order->order_date->format('d M Y') }} - {{ $order->time_slot }}
                                </p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-green-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                                <span class="text-xs px-2 py-1 font-semibold rounded-full
                                                                                    @if($order->status == 'completed') bg-green-100 text-green-800
                                                                                    @elseif($order->status == 'pending') bg-yellow-100 text-yellow-800
                                                                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-3">Belum ada transaksi</p>
                @endforelse
            </div>


            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] flex items-center gap-2 mb-4">
                    <i class="fa-solid fa-chart-column"></i> Statistik
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="p-4 bg-blue-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-blue-600">{{ $user->orders->count() }}</p>
                        <p class="text-sm text-gray-600">Total Order</p>
                    </div>

                    <div class="p-4 bg-green-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-green-600">
                            {{ $user->orders->where('status', 'completed')->count() }}
                        </p>
                        <p class="text-sm text-gray-600">Selesai</p>
                    </div>

                    <div class="p-4 bg-yellow-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $user->orders->where('status', 'pending')->count() }}
                        </p>
                        <p class="text-sm text-gray-600">Pending</p>
                    </div>

                    <div class="p-4 bg-purple-50 rounded-lg text-center">
                        <p class="text-2xl font-bold text-purple-600">
                            Rp
                            {{ number_format($user->orders->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}
                        </p>
                        <p class="text-sm text-gray-600">Total Pengeluaran</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection