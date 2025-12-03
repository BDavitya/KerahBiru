<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\WorkerSchedule;
use Illuminate\Http\Request;

class PublicWorkerController extends Controller
{
    public function showRegisterForm()
    {
        return view('public.worker-register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'gender' => 'required|in:Laki-laki,Perempuan',
            'price_per_hour' => 'required|numeric|min:0',
            'phone' => 'required|string',
            'whatsapp' => 'nullable|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'photo' => 'required|image|max:5120',
        ]);

        $data = $request->except('photo');
        $data['rating'] = 0;
        $data['total_orders'] = 0;
        $data['is_available'] = false;
        $data['approval_status'] = 'pending';

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('workers', 'public');
        }

        $worker = Worker::create($data);

        $days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
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

        return redirect()->route('worker.register.form')
            ->with('success', 'Pendaftaran berhasil! Mohon tunggu persetujuan admin.');
    }
}