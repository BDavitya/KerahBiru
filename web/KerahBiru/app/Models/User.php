<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'photo',
        'is_verified',
        'verification_token',
        'gamification_points',
        'last_shake_date',
        'latitude',
        'longitude',
        'preferred_currency',
        'preferred_timezone',
        'email_verified_at', // ✅ Tambahkan ini
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_shake_date' => 'datetime',
        'is_verified' => 'boolean',
        'gamification_points' => 'integer',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    // Relasi
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class);
    }

    // Helper method
    public function canShakeToday(): bool
    {
        if (!$this->last_shake_date) {
            return true;
        }
        
        return !$this->last_shake_date->isToday();
    }
}