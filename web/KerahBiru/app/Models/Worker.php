<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Worker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_title',
        'description',
        'gender',
        'rating',
        'total_orders',
        'price_per_hour',
        'photo',
        'latitude',
        'longitude',
        'phone',
        'whatsapp',
        'is_available',
        'approval_status',
    ];

    protected $casts = [
        'rating' => 'decimal:2',
        'price_per_hour' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
        'is_available' => 'boolean',
        'total_orders' => 'integer',
    ];
protected $appends = ['calculated_rating', 'completed_jobs', 'latest_review'];

public function orders()
{
    return $this->hasMany(Order::class);
}

public function getCalculatedRatingAttribute()
{
    $avg = $this->orders()
        ->whereNotNull('user_rating')
        ->avg('user_rating');

    return $avg ? round($avg, 2) : 0;
}

public function getCompletedJobsAttribute()
{
    return $this->orders()
        ->where('status', 'completed')
        ->count();
}

public function getLatestReviewAttribute()
{
    return $this->orders()
        ->whereNotNull('user_review')
        ->orderBy('updated_at', 'desc')
        ->value('user_review');
}


    public function schedules()
    {
        return $this->hasMany(WorkerSchedule::class);
    }

    public function scopeApproved($query)
    {
        return $query->where('approval_status', 'approved');
    }

    public function getDistanceFrom($userLat, $userLng)
    {
        $earthRadius = 6371;
        $latDiff = deg2rad($this->latitude - $userLat);
        $lngDiff = deg2rad($this->longitude - $userLng);
        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($userLat)) * cos(deg2rad($this->latitude)) *
             sin($lngDiff / 2) * sin($lngDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return round($earthRadius * $c, 2);
    }
}