<?php

namespace App\Http\Controllers;

use App\Models\Worker;
use App\Models\Order;

class WelcomeController extends Controller
{
    public function index()
    {
        // Get top 6 workers
        $topWorkers = Worker::where('approval_status', 'approved')
            ->where('total_orders', '>', 0)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        // Get latest 6 reviews
        $reviews = Order::whereNotNull('user_review')
            ->whereNotNull('user_rating')
            ->with(['user', 'worker'])
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        return view('welcome', compact('topWorkers', 'reviews'));
    }
}