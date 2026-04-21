<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'flight_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'travel_date',
        'passengers',
        'total_price',
        'booking_reference',
        'status',
        'special_requests',
    ];

    protected $casts = [
        'travel_date' => 'date',
        'total_price' => 'decimal:2',
        'passengers' => 'integer',
    ];

    public function flight()
    {
        return $this->belongsTo(Flight::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function generateBookingReference()
    {
        do {
            $reference = 'XFL' . strtoupper(uniqid()) . rand(100, 999);
        } while (self::where('booking_reference', $reference)->exists());
        
        return $reference;
    }
}
