@extends('admin.layout')

@section('title', 'Jadwal Worker')

@section('content')
    <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Jadwal {{ $worker->name }}</h2>
            <p class="text-gray-600 text-sm lg:text-base">Atur ketersediaan waktu untuk pekerja ini</p>
        </div>
        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('admin.workers.show', $worker->id) }}"
                class="px-4 lg:px-5 py-2 lg:py-3 rounded-lg bg-[#052c62] text-white hover:bg-[#031f46] transition text-sm lg:text-base text-center">
                <i class="fa-solid fa-id-badge mr-1 lg:mr-2"></i> Profil Pekerja
            </a>
            <a href="{{ route('admin.workers') }}"
                class="px-4 lg:px-5 py-2 lg:py-3 rounded-lg bg-gray-500 text-white hover:bg-gray-600 transition text-sm lg:text-base text-center">
                <i class="fa-solid fa-arrow-left mr-1 lg:mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow border border-gray-200 p-4 lg:p-6">
        <div class="mb-4 lg:mb-6 p-3 lg:p-4 bg-blue-50 border-l-4 border-blue-500 rounded text-sm lg:text-base">
            <p class="text-gray-700">
                <span class="text-green-600 font-bold">● Hijau</span> = Tersedia untuk dipesan &nbsp;
                <span class="text-red-600 font-bold">● Merah</span> = Tidak tersedia &nbsp;
                <span class="text-orange-600 font-bold">● Orange</span> = Sudah dipesan
            </p>
        </div>

        <div class="space-y-4 lg:space-y-6">
            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                <div class="border rounded-lg p-3 lg:p-4">
                    <h4 class="text-base lg:text-lg font-bold text-[#052c62] mb-3 flex items-center">
                        <i class="fa-solid fa-calendar-day mr-2"></i> {{ $day }}
                    </h4>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 lg:gap-3">
                        @php $slots = $schedules[$day] ?? collect(); @endphp

                        @forelse($slots as $schedule)
                            @if($schedule->is_booked)
                                {{-- Booked Slot - Orange --}}
                                <div class="w-full px-2 lg:px-3 py-2 rounded-lg text-xs lg:text-sm font-semibold border
                                                    bg-orange-50 text-orange-700 border-orange-300 cursor-not-allowed">
                                    <i class="fa-solid fa-lock mr-1"></i>
                                    {{ $schedule->time_slot }}
                                    <div class="text-xs mt-1">Dipesan:
                                        {{ $schedule->booked_date ? $schedule->booked_date->format('d M Y') : '-' }}</div>
                                </div>
                            @else
                                {{-- Available/Unavailable - Toggle Button --}}
                                <form action="{{ route('admin.schedules.toggle', $schedule->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full px-2 lg:px-3 py-2 rounded-lg text-xs lg:text-sm font-semibold border transition
                                                        {{ $schedule->is_available
                                ? 'bg-green-50 text-green-700 border-green-300 hover:bg-green-100'
                                : 'bg-red-50 text-red-700 border-red-300 hover:bg-red-100' }}">
                                        <i class="fa-solid {{ $schedule->is_available ? 'fa-check' : 'fa-xmark' }} mr-1"></i>
                                        {{ $schedule->time_slot }}
                                    </button>
                                </form>
                            @endif
                        @empty
                            <p class="col-span-full py-3 text-gray-500 text-center text-sm">Belum ada jadwal</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Stats --}}
    <div class="mt-4 lg:mt-6 grid grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-6">
        <div class="bg-white rounded-lg shadow-md p-3 lg:p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs lg:text-sm text-gray-500">Total Slot</p>
                    <h3 class="text-xl lg:text-2xl font-bold text-blue-600">{{ $schedules->flatten()->count() }}</h3>
                </div>
                <i class="fas fa-calendar text-2xl lg:text-3xl text-blue-500"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 lg:p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs lg:text-sm text-gray-500">Tersedia</p>
                    <h3 class="text-xl lg:text-2xl font-bold text-green-600">
                        {{ $schedules->flatten()->where('is_available', true)->where('is_booked', false)->count() }}
                    </h3>
                </div>
                <i class="fas fa-check text-2xl lg:text-3xl text-green-500"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 lg:p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs lg:text-sm text-gray-500">Dipesan</p>
                    <h3 class="text-xl lg:text-2xl font-bold text-orange-600">
                        {{ $schedules->flatten()->where('is_booked', true)->count() }}
                    </h3>
                </div>
                <i class="fas fa-lock text-2xl lg:text-3xl text-orange-500"></i>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow-md p-3 lg:p-4 border border-gray-200">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs lg:text-sm text-gray-500">Tidak Tersedia</p>
                    <h3 class="text-xl lg:text-2xl font-bold text-red-600">
                        {{ $schedules->flatten()->where('is_available', false)->where('is_booked', false)->count() }}
                    </h3>
                </div>
                <i class="fas fa-xmark text-2xl lg:text-3xl text-red-500"></i>
            </div>
        </div>
    </div>

@endsection