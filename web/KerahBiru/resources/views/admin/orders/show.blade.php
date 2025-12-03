@extends('admin.layout')

@section('title', 'Detail Pesanan')

@section('content')
    <div class="mb-8 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h2 class="text-2xl lg:text-3xl font-bold text-[#052c62]">Detail Pesanan #{{ $order->id }}</h2>
            <p class="text-gray-600 text-sm lg:text-base">Ringkasan dan status pengerjaan layanan</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-[#052c62]">
                <i class="fas fa-user mr-2"></i> Informasi Pengguna
            </h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-4">
                    @if($order->user->photo)
                        <img src="{{ asset('storage/' . $order->user->photo) }}" alt="{{ $order->user->name }}"
                            class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-blue-500 flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($order->user->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-lg">{{ $order->user->name }}</h4>
                        <p class="text-gray-600 text-sm">{{ $order->user->email }}</p>
                    </div>
                </div>
                <div class="border-t pt-3">
                    <p class="text-gray-700">
                        <strong>Telepon:</strong> 
                        @if($order->user->phone)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->user->phone) }}" 
                               target="_blank" 
                               class="text-green-600 hover:text-green-700">
                                {{ $order->user->phone }}
                            </a>
                        @else
                            -
                        @endif
                    </p>
                    <p class="text-gray-700"><strong>Alamat:</strong> {{ $order->user->address ?? '-' }}</p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-green-700">
                <i class="fas fa-person-digging mr-2"></i> Informasi Pekerja
            </h3>
            <div class="space-y-3">
                <div class="flex items-center space-x-4">
                    @if($order->worker->photo)
                        <img src="{{ asset('storage/' . $order->worker->photo) }}" alt="{{ $order->worker->name }}"
                            class="w-16 h-16 rounded-full object-cover">
                    @else
                        <div
                            class="w-16 h-16 rounded-full bg-green-500 flex items-center justify-center text-white font-bold text-xl">
                            {{ substr($order->worker->name, 0, 1) }}
                        </div>
                    @endif
                    <div>
                        <h4 class="font-bold text-lg">{{ $order->worker->name }}</h4>
                        <p class="text-gray-600 text-sm">{{ $order->worker->job_title }}</p>
                        <div class="flex items-center space-x-1 text-yellow-500 mt-1">
                            <i class="fas fa-star"></i>
                            <span class="font-bold">{{ $order->worker->rating }}</span>
                        </div>
                    </div>
                </div>
                <div class="border-t pt-3">
                    <p class="text-gray-700">
                        <strong>Telepon:</strong> 
                        @php
                            $phone = preg_replace('/[^0-9]/', '', $order->worker->phone);
                            $orderInfo = "Halo, saya pelanggan dari pesanan #{$order->id}. Tanggal: {$order->order_date->format('d M Y')}, Waktu: {$order->time_slot}.";
                        @endphp
                        <a href="https://wa.me/{{ $phone }}?text={{ urlencode($orderInfo) }}" 
                           target="_blank" 
                           class="text-green-600 hover:text-green-700">
                            {{ $order->worker->phone }}
                        </a>
                    </p>
                    <p class="text-gray-700"><strong>Harga:</strong> Rp
                        {{ number_format($order->worker->price_per_hour, 0, ',', '.') }}/jam
                    </p>
                </div>
            </div>
        </div>

        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-purple-600">
                <i class="fas fa-info-circle mr-2"></i> Detail Pesanan
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="font-semibold">{{ $order->order_date->format('d M Y') }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Waktu:</span>
                    <span class="font-semibold">{{ $order->time_slot }}</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Jarak:</span>
                    <span class="font-semibold">{{ $order->distance_km }} km</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Total Harga:</span>
                    <span class="font-bold text-green-600 text-lg">Rp
                        {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Status:</span>
                    @php
                        $colors = [
                            'pending' => 'bg-yellow-100 text-yellow-700',
                            'accepted' => 'bg-blue-100 text-blue-700',
                            'in_progress' => 'bg-purple-100 text-purple-700',
                            'completed' => 'bg-green-100 text-green-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $colors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </div>
            </div>
            @if($order->status == 'pending')
                <div class="mt-6 flex gap-3">
                    <form action="{{ route('admin.orders.confirm', $order->id) }}" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition">
                            <i class="fas fa-check"></i> Konfirmasi
                        </button>
                    </form>
                    <button onclick="showCancelModal({{ $order->id }})" 
                            class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                        <i class="fas fa-times"></i> Batalkan
                    </button>
                </div>
            @endif
        </div>

        
        <div class="bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-orange-600">
                <i class="fas fa-clock mr-2"></i> Progress Pekerjaan
            </h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <i class="fas fa-check-circle text-green-500 mt-1"></i>
                    <div>
                        <p class="font-semibold">Pesanan Dibuat</p>
                        <p class="text-sm text-gray-600">{{ $order->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                @if($order->worker_arrived_at)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <p class="font-semibold">Pekerja Tiba</p>
                            <p class="text-sm text-gray-600">{{ $order->worker_arrived_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                @endif
                @if($order->work_started_at)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <p class="font-semibold">Pekerjaan Dimulai</p>
                            <p class="text-sm text-gray-600">{{ $order->work_started_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                @endif
                @if($order->work_completed_at)
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-check-circle text-green-500 mt-1"></i>
                        <div>
                            <p class="font-semibold">Pekerjaan Selesai</p>
                            <p class="text-sm text-gray-600">{{ $order->work_completed_at->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    
    @if($order->photo_before || $order->photo_after)
        <div class="mt-6 bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-indigo-600">
                <i class="fas fa-images mr-2"></i> Dokumentasi
            </h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @if($order->photo_before)
                    <div>
                        <h4 class="font-semibold mb-2">Foto Sebelum</h4>
                        <img src="{{ asset('storage/' . $order->photo_before) }}" alt="Before"
                            class="w-full h-64 object-cover rounded-lg">
                    </div>
                @endif
                @if($order->photo_after)
                    <div>
                        <h4 class="font-semibold mb-2">Foto Sesudah</h4>
                        <img src="{{ asset('storage/' . $order->photo_after) }}" alt="After"
                            class="w-full h-64 object-cover rounded-lg">
                    </div>
                @endif
            </div>
        </div>
    @endif

    
    @if($order->user_rating)
        <div class="mt-6 bg-white rounded-lg shadow-md p-6 border border-gray-200">
            <h3 class="text-xl font-bold mb-4 flex items-center text-yellow-500">
                <i class="fas fa-star mr-2"></i> Ulasan
            </h3>
            <div class="flex items-center space-x-2 mb-2">
                @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star {{ $i <= $order->user_rating ? 'text-yellow-500' : 'text-gray-300' }}"></i>
                @endfor
                <span class="font-bold">{{ $order->user_rating }}/5</span>
            </div>
            @if($order->user_review)
                <p class="text-gray-700 mt-2">{{ $order->user_review }}</p>
            @endif
        </div>
    @endif

    
    <div id="cancelModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full mx-4">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <h3 class="text-lg font-bold text-gray-900 mb-2">Batalkan Pesanan?</h3>
                <p class="text-sm text-gray-500 mb-6">
                    Jadwal akan dikembalikan tersedia setelah pesanan dibatalkan.
                </p>
                <div class="flex gap-3">
                    <button onclick="hideModal()" 
                            class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition">
                        Batal
                    </button>
                    <form id="cancelForm" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition">
                            Ya, Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showCancelModal(orderId) {
            const modal = document.getElementById('cancelModal');
            const form = document.getElementById('cancelForm');
            form.action = `/admin/orders/${orderId}/cancel`;
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function hideModal() {
            const modal = document.getElementById('cancelModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        // Close modal when clicking outside
        document.getElementById('cancelModal').addEventListener('click', function(e) {
            if (e.target === this) {
                hideModal();
            }
        });
    </script>
@endsection