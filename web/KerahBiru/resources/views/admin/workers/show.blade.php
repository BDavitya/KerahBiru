@extends('admin.layout')

@section('title', 'Detail Mitra Pekerja')

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Detail Mitra Pekerja</h2>
            <p class="text-gray-600 text-sm lg:text-base">Informasi lengkap mengenai mitra pekerja di Kerah Biru</p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('admin.schedules', $worker->id) }}"
                class="bg-[#6f42c1] text-white px-4 lg:px-5 py-2 rounded-lg hover:bg-purple-700 transition text-sm lg:text-base">
                <i class="fa-solid fa-calendar-days"></i> Jadwal
            </a>

            <a href="{{ route('admin.workers.edit', $worker->id) }}"
                class="bg-yellow-500 text-white px-4 lg:px-5 py-2 rounded-lg hover:bg-yellow-600 transition text-sm lg:text-base">
                <i class="fa-solid fa-pen-to-square"></i> Edit
            </a>

            <a href="{{ route('admin.workers') }}"
                class="bg-gray-600 text-white px-4 lg:px-5 py-2 rounded-lg hover:bg-gray-700 transition text-sm lg:text-base">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Profile --}}
        <div class="bg-white shadow-md p-6 rounded-lg">
            @if($worker->photo)
                <img src="{{ asset('storage/' . $worker->photo) }}" class="w-full h-64 object-cover rounded-lg shadow">
            @else
                <div class="w-full h-64 bg-[#052c62] rounded-lg flex items-center justify-center shadow">
                    <span class="text-7xl text-white font-bold">{{ strtoupper(substr($worker->name, 0, 1)) }}</span>
                </div>
            @endif

            <h3 class="text-2xl font-bold text-center mt-4 text-[#052c62]">{{ $worker->name }}</h3>
            <p class="text-center text-gray-600">{{ $worker->job_title }}</p>

            <div class="flex justify-center mt-3 gap-3 items-center flex-wrap">
                <div class="flex items-center text-yellow-500 text-lg gap-1">
                    <i class="fa-solid fa-star"></i> <span class="font-bold">{{ $worker->rating }}</span>
                </div>
                <span class="text-gray-600 text-sm">{{ $worker->total_orders }} pesanan</span>
            </div>

            <p class="text-center font-bold text-green-600 text-xl mt-3">
                Rp {{ number_format($worker->price_per_hour, 0, ',', '.') }}/jam
            </p>

            <div class="flex justify-center gap-2 mt-4 flex-wrap">
                <span class="px-3 py-1 text-sm rounded-full font-semibold bg-blue-100 text-blue-800">
                    <i class="fa-solid {{ $worker->gender === 'Laki-laki' ? 'fa-person' : 'fa-person-dress' }}"></i>
                    {{ $worker->gender }}
                </span>

                @if($worker->is_available)
                    <span class="px-3 py-1 text-sm rounded-full font-semibold bg-green-100 text-green-800">
                        <i class="fa-solid fa-circle-check"></i> Tersedia
                    </span>
                @else
                    <span class="px-3 py-1 text-sm rounded-full font-semibold bg-red-100 text-red-800">
                        <i class="fa-solid fa-circle-xmark"></i> Tidak Tersedia
                    </span>
                @endif
            </div>
        </div>

        {{-- Right Column --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- Contact --}}
            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-address-book text-[#052c62]"></i> Informasi Kontak
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Telepon</p>
                        @php
                            $phone = preg_replace('/[^0-9]/', '', $worker->phone);
                        @endphp
                        <p class="font-semibold text-gray-800">
                            <a href="https://wa.me/{{ $phone }}" target="_blank"
                                class="text-green-600 hover:text-green-700">
                                {{ $worker->phone }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="text-gray-500">WhatsApp</p>
                        @if($worker->whatsapp)
                            @php
                                $whatsapp = preg_replace('/[^0-9]/', '', $worker->whatsapp);
                            @endphp
                            <p class="font-semibold text-gray-800">
                                <a href="https://wa.me/{{ $whatsapp }}" target="_blank"
                                    class="text-green-600 hover:text-green-700">
                                    {{ $worker->whatsapp }}
                                </a>
                            </p>
                        @else
                            <p class="font-semibold text-gray-800">-</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-gray-500">Lokasi (Lat)</p>
                        <p class="font-semibold text-gray-800">{{ $worker->latitude }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Lokasi (Long)</p>
                        <p class="font-semibold text-gray-800">{{ $worker->longitude }}</p>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            @if($worker->description)
                <div class="bg-white shadow-md p-6 rounded-lg">
                    <h3 class="text-xl font-bold text-[#052c62] mb-3 flex items-center gap-2">
                        <i class="fa-solid fa-circle-info text-[#0aa04f]"></i> Deskripsi Pekerja
                    </h3>
                    <p class="text-gray-700 leading-relaxed">{{ $worker->description }}</p>
                </div>
            @endif

            {{-- Recent Orders --}}
            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-receipt"></i> Pesanan Terbaru
                </h3>

                @forelse($worker->orders->take(5) as $order)
                    <div
                        class="border-l-4 pl-4 py-3 mb-3 shadow-sm rounded-md
                                                                {{ $order->status === 'completed' ? 'border-green-500' : 'border-yellow-500' }}">
                        <div class="flex flex-col sm:flex-row justify-between gap-2 text-sm">
                            <div>
                                <p class="font-semibold text-gray-800">{{ $order->user->name }}</p>
                                <p class="text-gray-500">
                                    {{ $order->order_date->format('d M Y') }} - {{ $order->time_slot }}
                                </p>
                            </div>
                            <div class="sm:text-right">
                                <p class="font-bold text-green-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                                            @if($order->status === 'completed') bg-green-100 text-green-800
                                                                            @elseif($order->status === 'pending') bg-yellow-100 text-yellow-800
                                                                            @else bg-blue-100 text-blue-800 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>
                        </div>

                        @if($order->user_rating)
                            <div class="mt-2 flex gap-1 text-yellow-500 text-xs">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa-solid fa-star {{ $i <= $order->user_rating ? '' : 'text-gray-300' }}"></i>
                                @endfor
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-center text-gray-500 py-3">Belum ada pesanan</p>
                @endforelse
            </div>

            {{-- Statistics --}}
            <div class="bg-white shadow-md p-6 rounded-lg">
                <h3 class="text-xl font-bold text-[#052c62] mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-chart-column text-orange-500"></i> Statistik Kinerja
                </h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div class="p-4 bg-blue-50 rounded-lg">
                        <p class="text-2xl font-bold text-blue-600">{{ $worker->orders->count() }}</p>
                        <p class="text-gray-600 text-sm">Total Pesanan</p>
                    </div>
                    <div class="p-4 bg-green-50 rounded-lg">
                        <p class="text-2xl font-bold text-green-600">
                            {{ $worker->orders->where('status', 'completed')->count() }}
                        </p>
                        <p class="text-gray-600 text-sm">Selesai</p>
                    </div>
                    <div class="p-4 bg-yellow-50 rounded-lg">
                        <p class="text-2xl font-bold text-yellow-600">
                            {{ $worker->orders->where('status', 'pending')->count() }}
                        </p>
                        <p class="text-gray-600 text-sm">Pending</p>
                    </div>
                    <div class="p-4 bg-purple-50 rounded-lg">
                        <p class="text-xl lg:text-2xl font-bold text-purple-600">
                            Rp
                            {{ number_format($worker->orders->where('status', 'completed')->sum('total_price'), 0, ',', '.') }}
                        </p>
                        <p class="text-gray-600 text-sm">Pendapatan</p>
                    </div>
                </div>
            </div>

        </div>

    </div>
@endsection