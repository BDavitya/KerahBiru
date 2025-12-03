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
            // Calculate actual rating from orders
            $avgRating = $worker->orders()->whereNotNull('user_rating')->avg('user_rating');
            $worker->rating = $avgRating ? round($avgRating, 2) : 0;
            
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
                    $workers = $workers->sortByDesc('rating')->values();
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
        try {
            $worker = Worker::with('schedules')->where('approval_status', 'approved')->findOrFail($id);
            
            // Calculate actual rating
            $avgRating = $worker->orders()->whereNotNull('user_rating')->avg('user_rating');
            $worker->rating = $avgRating ? round($avgRating, 2) : 0;

            return response()->json([
                'success' => true,
                'worker' => $worker,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Worker not found',
            ], 404);
        }
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