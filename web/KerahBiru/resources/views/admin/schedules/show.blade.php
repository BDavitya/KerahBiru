@extends('admin.layout')

@section('title', 'Detail User')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h2 class="text-3xl font-bold text-[#052c62]">{{ $user->name }}</h2>
            <p class="text-gray-600">Detail informasi akun dan riwayat transaksi</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}"
                class="px-5 py-3 rounded-lg bg-yellow-500 text-white hover:bg-yellow-600 transition">
                <i class="fa-solid fa-pen-to-square mr-2"></i> Edit
            </a>
            <a href="{{ route('admin.users') }}"
                class="px-5 py-3 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Profile Card --}}
        <x-user-card :user="$user" />

        {{-- Detail --}}
        <div class="lg:col-span-2 space-y-6">
            <x-user-contact :user="$user" />
            <x-user-orders :user="$user" limit="5" />
            <x-user-stats :user="$user" />
            @if($user->gamification_points)
                <x-user-gamification :user="$user" />
            @endif
        </div>
    </div>
@endsection