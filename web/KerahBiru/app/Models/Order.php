<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'worker_id',
        'order_date',
        'time_slot',
        'distance_km',
        'total_price',
        'status',
        'photo_before',
        'photo_after',
        'user_rating',
        'user_review',
        'worker_arrived_at',
        'work_started_at',
        'work_completed_at',
    ];

    protected $casts = [
        'order_date' => 'date',
        'distance_km' => 'decimal:2',
        'total_price' => 'decimal:2',
        'user_rating' => 'decimal:2',
        'worker_arrived_at' => 'datetime',
        'work_started_at' => 'datetime',
        'work_completed_at' => 'datetime',
    ];

    // Relasi
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function worker()
    {
        return $this->belongsTo(Worker::class);
    }

    // Helper method buat status yang user-friendly
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Konfirmasi',
            'accepted' => 'Diterima',
            'on_the_way' => 'Sedang Menuju Lokasi',
            'in_progress' => 'Sedang Bekerja',
            'completed' => 'Selesai',
            'cancelled' => 'Dibatalkan',
            default => 'Unknown',
        };
    }
}