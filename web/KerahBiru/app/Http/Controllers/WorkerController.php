<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\User;
use Illuminate\Http\Request;

class WorkerController extends Controller
{
   public function index(Request $request)
{
    try {
        $userId = $request->query('user_id');
        $user = User::find($userId);
        
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found',
            ], 404);
        }

        $query = Worker::with('schedules')->where('approval_status', 'approved');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('job_title', 'like', "%{$search}%");
            });
        }

        if ($request->has('gender') && $request->gender !== 'Semua') {
            $query->where('gender', $request->gender);
        }

        if ($request->has('sort_by') && $request->sort_by === 'Terpercaya') {
            $query->where('rating', '>=', 4.8);
        }

        $workers = $query->get();

        $workers = $workers->map(function($worker) use ($user) {
            $workerArray = $worker->toArray();
$workerArray['rating'] = $worker->calculated_rating;
$workerArray['total_jobs'] = $worker->completed_jobs;
$workerArray['review'] = $worker->latest_review;

            $distance = $this->calculateDistance(
                $user->latitude ?? -7.7956,
                $user->longitude ?? 110.3695,
                $worker->latitude,
                $worker->longitude
            );
            
            $workerArray = $worker->toArray();
            $workerArray['distance'] = $distance;
            
            return $workerArray;
        });

        if ($request->has('sort_by')) {
            $workers = collect($workers);
            
            switch ($request->sort_by) {
                case 'Terdekat':
                    $workers = $workers->sortBy('distance')->values();
                    break;
                case 'Termurah':
                    $workers = $workers->sortBy('price_per_hour')->values();
                    break;
                case 'Terpercaya':
                    $workers = $workers->sortByDesc('calculated_rating')->values();
                    break;
            }
        }

        return response()->json([
            'success' => true,
            'workers' => $workers,
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error: ' . $e->getMessage(),
        ], 500);
    }
}

   public function show($id)
{
    $worker = Worker::with('schedules')->findOrFail($id);

    // Hitung rating
    $avgRating = $worker->orders()->whereNotNull('user_rating')->avg('user_rating');
    $worker->calculated_rating = $avgRating ? round($avgRating, 2) : 0;

    // Ambil semua review yang completed
    $reviews = $worker->orders()
    ->where('status', 'completed')
    ->whereNotNull('user_rating')
    ->with('user:id,name')
    ->orderBy('work_completed_at', 'desc')
    ->get();

    // Tambahkan user name
    $reviews->transform(function ($item) {
        $item->user_name = $item->user->name ?? 'Pengguna';
        return $item;
    });

    return response()->json([
        'success' => true,
        'worker' => $worker,
        'reviews' => $reviews,
        'total_reviews' => $reviews->count(),
    ]);
}


    public function getAvailableSchedules(Request $request, $workerId)
    {
        try {
            $request->validate([
                'date' => 'required|date',
            ]);

            $date = \Carbon\Carbon::parse($request->date);
            $dayName = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
            $day = $dayName[$date->dayOfWeek];

            $worker = Worker::findOrFail($workerId);
            
            $schedules = $worker->schedules()
                ->where('day', $day)
                ->where('is_available', true)
                ->where(function($query) use ($date) {
                    $query->where('is_booked', false)
                        ->orWhere(function($q) use ($date) {
                            $q->where('is_booked', true)
                              ->whereDate('booked_date', '!=', $date);
                        });
                })
                ->get()
                ->map(function($schedule) use ($date) {
                    return [
                        'id' => $schedule->id,
                        'time_slot' => $schedule->time_slot,
                        'is_available' => true,
                        'is_booked' => $schedule->is_booked && $schedule->booked_date && $schedule->booked_date->isSameDay($date),
                    ];
                });

            return response()->json([
                'success' => true,
                'date' => $date->format('Y-m-d'),
                'day' => $day,
                'schedules' => $schedules,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $latDiff = deg2rad($lat2 - $lat1);
        $lonDiff = deg2rad($lon2 - $lon1);
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lonDiff / 2) * sin($lonDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}