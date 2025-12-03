@extends('admin.layout')

@section('title', 'Manajemen Pengguna')

@section('content')
    <div class="mb-8">
        <h2 class="text-3xl font-bold text-[#052c62]">Manajemen Pengguna</h2>
        <p class="text-gray-600">Kelola seluruh data pengguna yang terdaftar di Kerah Biru</p>
    </div>

    {{-- Search Filter --}}
    <div class="bg-white rounded-lg shadow-md p-6 mb-6 border border-gray-200">
        <form action="{{ route('admin.users') }}" method="GET" class="flex gap-4">
            <input type="text" name="search" placeholder="Cari pengguna..."
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-[#052c62]"
                value="{{ request('search') }}">
            
            <button type="submit" class="bg-[#052c62] text-white px-6 py-2 rounded-lg hover:opacity-90 transition">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>
    </div>

    {{-- Data Table --}}
    <div class="bg-white rounded-lg shadow-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-[#052c62] text-white text-sm">
                    <tr>
                        <th class="px-6 py-3 text-left">ID</th>
                        <th class="px-6 py-3">Foto</th>
                        <th class="px-6 py-3 text-left">Nama</th>
                        <th class="px-6 py-3 text-left">Email</th>
                        <th class="px-6 py-3 text-left">Telepon</th>
                        <th class="px-6 py-3 text-center">Status</th>
                        <th class="px-6 py-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm">{{ $user->id }}</td>

                            <td class="px-6 py-4 text-center">
                                @if($user->photo)
                                    <img src="{{ asset('storage/' . $user->photo) }}"
                                        class="w-12 h-12 rounded-full object-cover shadow-sm">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-[#052c62] text-white flex items-center justify-center font-bold">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-sm font-semibold text-gray-800">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">{{ $user->phone ?? '-' }}</td>

                            <td class="px-6 py-4 text-center">
                                @if($user->is_verified)
                                    <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-800 font-semibold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-check-circle"></i> Terverifikasi
                                    </span>
                                @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800 font-semibold inline-flex items-center gap-1">
                                        <i class="fa-solid fa-clock"></i> Pending
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                        class="bg-blue-600 text-white px-3 py-1 rounded-md hover:bg-blue-700 transition">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                        class="bg-yellow-500 text-white px-3 py-1 rounded-md hover:bg-yellow-600 transition">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <form action="{{ route('admin.users.delete', $user->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="bg-red-500 text-white px-3 py-1 rounded-md hover:bg-red-600 transition">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-8 text-center text-gray-500">
                                Belum ada pengguna terdaftar
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        <div class="px-6 py-4 bg-gray-50">
            {{ $users->links() }}
        </div>
    </div>
@endsection
