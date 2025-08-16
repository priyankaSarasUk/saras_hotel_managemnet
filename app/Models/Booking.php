<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'room_id',
        'user_id',   //  allow mass assignment
        'check_in',
        'check_out',
        'members',
        'adults',
        'childs',
        'amount',
        'id_front',
        'id_back',
    ];

    protected $casts = [
        'id_front' => 'array',
        'id_back'  => 'array',
    ];

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
        return $this->belongsTo(User::class); //  connect booking to user
    }
}
