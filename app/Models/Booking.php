<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'customer_id',
        'room_id',
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
        'id_back' => 'array',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
}
