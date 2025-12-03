@extends('admin.layout')

@section('title', 'Manajemen Mitra Pekerja')

@section('content')
    <div class="mb-6 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Manajemen Mitra Pekerja</h2>
            <p class="text-gray-600 text-sm lg:text-base">Kelola seluruh mitra pekerja yang terdaftar</p>
        </div>
        <a href="{{ route('admin.workers.create') }}"
            class="bg-[#052c62] hover:bg-[#031f46] text-white px-4 lg:px-6 py-2 lg:py-3 rounded-lg transition text-sm lg:text-base whitespace-nowrap">
            <i class="fa-solid fa-user-plus mr-1"></i> Tambah Pekerja
        </a>
    </div>


    <div class="bg-white rounded-lg shadow-md p-4 lg:p-6 mb-6 border border-gray-200">
        <form action="{{ route('admin.workers') }}" method="GET" class="flex flex-col lg:flex-row gap-3 lg:gap-4">
            <input type="text" name="search" placeholder="Cari pekerja..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#052c62] text-sm lg:text-base"
                value="{{ request('search') }}">
            <select name="status"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#052c62] text-sm lg:text-base">
                <option value="">Semua Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
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
                <thead class="bg-[#052c62] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left">Foto</th>
                        <th class="px-4 py-3 text-left">Nama</th>
                        <th class="px-4 py-3 text-left hidden lg:table-cell">Pekerjaan</th>
                        <th class="px-4 py-3 text-center">Rating</th>
                        <th class="px-4 py-3 text-center hidden sm:table-cell">Harga/Jam</th>
                        <th class="px-4 py-3 text-center">Status</th>
                        <th class="px-4 py-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($workers as $worker)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                @if($worker->photo)
                                    <img src="{{ asset('storage/' . $worker->photo) }}"
                                        class="w-10 h-10 lg:w-12 lg:h-12 rounded-full object-cover">
                                @else
                                    <div
                                        class="w-10 h-10 lg:w-12 lg:h-12 rounded-full bg-[#052c62] text-white flex items-center justify-center font-bold text-sm lg:text-base">
                                        {{ strtoupper(substr($worker->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-4 py-3 font-semibold text-[#052c62]">{{ $worker->name }}</td>
                            <td class="px-4 py-3 hidden lg:table-cell">{{ $worker->job_title }}</td>
                            <td class="px-4 py-3 text-center">
                                <span class="text-yellow-500 font-bold text-sm lg:text-base">
                                    <i class="fas fa-star"></i> {{ number_format($worker->rating, 1) }}
                                </span>
                            </td>
                            <td
                                class="px-4 py-3 text-center font-bold text-green-600 hidden sm:table-cell text-sm lg:text-base">
                                Rp {{ number_format($worker->price_per_hour, 0, ',', '.') }}
                            </td>
                            <td class="px-4 py-3 text-center">
                                @if($worker->approval_status == 'approved')
                                    <span
                                        class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Disetujui</span>
                                @elseif($worker->approval_status == 'pending')
                                    <span
                                        class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Pending</span>
                                @else
                                    <span
                                        class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Ditolak</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">
                                <div class="flex justify-center gap-1 lg:gap-2 flex-wrap">
                                    @if($worker->approval_status == 'pending')
                                        <form action="{{ route('admin.workers.approve', $worker->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button
                                                class="p-2 rounded bg-green-500 hover:bg-green-600 text-white transition text-xs"
                                                title="Setujui">
                                                <i class="fa-solid fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('admin.workers.reject', $worker->id) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            <button class="p-2 rounded bg-red-500 hover:bg-red-600 text-white transition text-xs"
                                                title="Tolak">
                                                <i class="fa-solid fa-times"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('admin.workers.show', $worker->id) }}"
                                        class="p-2 rounded bg-[#052c62] hover:bg-[#031f46] text-white transition text-xs">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.workers.edit', $worker->id) }}"
                                        class="p-2 rounded bg-yellow-500 hover:bg-yellow-600 text-white transition text-xs">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.workers.delete', $worker->id) }}" method="POST"
                                        onsubmit="return confirmDelete(this)">
                                        @csrf @method('DELETE')
                                        <button class="p-2 rounded bg-red-500 hover:bg-red-600 text-white transition text-xs">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-10 text-center text-gray-500">
                                <i class="fa-solid fa-users-slash text-5xl mb-2"></i><br>
                                Belum ada mitra pekerja terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50">
            {{ $workers->links() }}
        </div>
    </div>

    <script>
        function confirmDelete(form) {
            Swal.fire({
                title: 'Hapus Pekerja?',
                text: 'Data pekerja akan dihapus permanen!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc2626',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
            return false;
        }
    </script>
@endsection