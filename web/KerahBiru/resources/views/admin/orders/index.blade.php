@extends('admin.layout')

@section('title', 'Manajemen Pesanan')

@section('content')
    <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Manajemen Pesanan</h2>
            <p class="text-gray-600 text-sm lg:text-base">Kelola seluruh data transaksi dan pesanan pelanggan</p>
        </div>
    </div>


    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6 mb-6 border border-gray-200">
        <form action="{{ route('admin.orders') }}" method="GET" class="flex flex-col lg:flex-row gap-3 lg:gap-4">
            <input type="text" name="search" placeholder="Cari pesanan (pengguna, pekerja)..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#052c62] text-sm lg:text-base"
                value="{{ request('search') }}">

            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#052c62] text-sm lg:text-base">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Accepted</option>
                <option value="on_the_way" {{ request('status') == 'on_the_way' ? 'selected' : '' }}>On The Way</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>

            <button type="submit"
                class="bg-[#052c62] text-white px-4 lg:px-6 py-2 rounded-lg hover:opacity-90 transition text-sm lg:text-base whitespace-nowrap">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>
    </div>
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-[#052c62]/10">
                    <tr>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62]">#</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62]">User</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62] hidden md:table-cell">
                            Pekerja</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62]">Tanggal</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62] hidden sm:table-cell">
                            Waktu</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62] hidden lg:table-cell">
                            Jarak</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-left font-semibold text-[#052c62]">Harga</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-center font-semibold text-[#052c62]">Status</th>
                        <th class="px-3 lg:px-6 py-3 lg:py-4 text-center font-semibold text-[#052c62]">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 lg:px-6 py-3 lg:py-4">{{ $order->id }}</td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4">
                                @if($order->user)
                                    <p class="font-semibold text-[#052c62]">{{ Str::limit($order->user->name, 15) }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($order->user->email, 20) }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">User Deleted</p>
                                @endif
                            </td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4 hidden md:table-cell">
                                @if($order->worker)
                                    <p class="font-semibold">{{ Str::limit($order->worker->name, 15) }}</p>
                                    <p class="text-xs text-gray-500">{{ Str::limit($order->worker->job_title, 20) }}</p>
                                @else
                                    <p class="text-gray-400 italic text-xs">Pekerja Dihapus</p>
                                @endif
                            </td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4">{{ $order->order_date->format('d M Y') }}</td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 hidden sm:table-cell">{{ $order->time_slot }}</td>
                            <td class="px-3 lg:px-6 py-3 lg:py-4 hidden lg:table-cell">{{ $order->distance_km }} km</td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4 font-bold text-green-600">
                                Rp {{ number_format($order->total_price, 0, ',', '.') }}
                            </td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4 text-center">
                                @php
                                    $colors = [
                                        'pending' => 'bg-yellow-100 text-yellow-700',
                                        'accepted' => 'bg-blue-100 text-blue-700',
                                        'on_the_way' => 'bg-indigo-100 text-indigo-700',
                                        'in_progress' => 'bg-purple-100 text-purple-700',
                                        'completed' => 'bg-green-100 text-green-700',
                                        'cancelled' => 'bg-red-100 text-red-700',
                                    ];
                                @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>

                            <td class="px-3 lg:px-6 py-3 lg:py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="p-2 rounded bg-[#052c62] hover:bg-[#031f46] text-white transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST"
                                        onsubmit="return confirmDelete(this)">
                                        @csrf @method('DELETE')
                                        <button class="p-2 rounded bg-red-500 hover:bg-red-600 text-white transition">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-10 text-center text-gray-500">
                                <i class="fa-solid fa-box-open text-5xl mb-2"></i><br>
                                Belum ada data pesanan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 bg-gray-50">
            {{ $orders->links() }}
        </div>
    </div>
@endsection