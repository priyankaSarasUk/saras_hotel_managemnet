<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'room_id',
        'user_id',
        'male',
        'female',
        'childs',
        'members',
        'adults',
        'amount',
        'id_front',
        'id_back',
        'purpose',
        'arrival_from',
        'vehicle_number',
        'check_in',
        'check_out',
        'status',
        'relation', 
    ];

    protected $casts = [
        'check_in' => 'datetime',
        'check_out' => 'datetime',
        'id_front' => 'array', // Cast multiple front IDs as array
        'id_back' => 'array',  // Cast multiple back IDs as array
    ];

    protected $attributes = [
        'male' => 0,
        'female' => 0,
        'childs' => 0,
        'members' => 1,
        'adults' => 1,
    ];

    protected static function booted()
    {
        static::creating(function ($booking) {
            // Set default check-in and check-out if not provided
            if (!$booking->check_in) {
                $booking->check_in = now();
            }
            if (!$booking->check_out) {
                $booking->check_out = now()->addDay()->setTime(11, 0);
            }

            // Auto-calculate total members and adults
            $booking->members = ($booking->male ?? 0) + ($booking->female ?? 0) + ($booking->childs ?? 0);
            $booking->adults = ($booking->male ?? 0) + ($booking->female ?? 0);
        });

        static::updating(function ($booking) {
            // Recalculate totals on update
            $booking->members = ($booking->male ?? 0) + ($booking->female ?? 0) + ($booking->childs ?? 0);
            $booking->adults = ($booking->male ?? 0) + ($booking->female ?? 0);
        });
    }

    // Relationships
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
