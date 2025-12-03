<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Worker;
use App\Models\WorkerSchedule;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Workers
        $workers = [
            [
                'name' => 'Budi Santoso',
                'job_title' => 'Tukang Bangunan',
                'description' => 'Berpengalaman 10 tahun dalam konstruksi bangunan, renovasi rumah, dan pekerjaan sipil lainnya.',
                'gender' => 'Laki-Laki',
                'rating' => 4.8,
                'total_orders' => 120,
                'price_per_hour' => 75000,
                'photo' => 'workers/budi.jpg',
                'latitude' => -7.7956,
                'longitude' => 110.3695,
                'phone' => '081234567890',
                'whatsapp' => '081234567890',
            ],
            [
                'name' => 'Rina Putri',
                'job_title' => 'Tukang Listrik',
                'description' => 'Ahli dalam instalasi listrik rumah, perbaikan korsleting, dan pemasangan lampu.',
                'gender' => 'Perempuan',
                'rating' => 4.6,
                'total_orders' => 95,
                'price_per_hour' => 90000,
                'photo' => 'workers/rina.jpg',
                'latitude' => -7.8012,
                'longitude' => 110.3645,
                'phone' => '081234567891',
                'whatsapp' => '081234567891',
            ],
            [
                'name' => 'Andi Wijaya',
                'job_title' => 'Tukang Las',
                'description' => 'Spesialis pengelasan logam, pagar besi, kanopi, dan konstruksi baja.',
                'gender' => 'Laki-Laki',
                'rating' => 4.9,
                'total_orders' => 150,
                'price_per_hour' => 110000,
                'photo' => 'workers/andi.jpg',
                'latitude' => -7.7989,
                'longitude' => 110.3712,
                'phone' => '081234567892',
                'whatsapp' => '081234567892',
            ],
            [
                'name' => 'Siti Aulia',
                'job_title' => 'Asisten Rumah Tangga',
                'description' => 'Berpengalaman dalam membersihkan rumah, mencuci, menyetrika, dan memasak.',
                'gender' => 'Perempuan',
                'rating' => 4.7,
                'total_orders' => 200,
                'price_per_hour' => 60000,
                'photo' => 'workers/siti.jpg',
                'latitude' => -7.7945,
                'longitude' => 110.3678,
                'phone' => '081234567893',
                'whatsapp' => '081234567893',
            ],
        ];

        foreach ($workers as $workerData) {
            $worker = Worker::create($workerData);

            // Seed jadwal untuk setiap pekerja
            $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $timeSlots = ['08:00-10:00', '10:00-12:00', '13:00-15:00', '15:00-17:00'];

            foreach ($days as $day) {
                foreach ($timeSlots as $slot) {
                    WorkerSchedule::create([
                        'worker_id' => $worker->id,
                        'day' => $day,
                        'time_slot' => $slot,
                        'is_available' => true,
                    ]);
                }
            }
        }
    }
}