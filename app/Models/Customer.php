<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'address',
        'email',
        'user_id',
    ];

    /**
     * Each customer belongs to a user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Each customer can have many bookings
     */
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
