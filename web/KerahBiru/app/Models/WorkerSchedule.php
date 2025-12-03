<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkerSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'worker_id',
        'day',
        'time_slot',
        'is_available',
        'booked_date',
        'is_booked',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'is_booked' => 'boolean',
        'booked_date' => 'date',
    ];

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }
}