<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flight extends Model
{
    use HasFactory;
    protected $fillable = [
        'from_city',
        'to_city',
        'airline',
        'imageAirline',
        'cityimg',
        'oldprice',
        'newprice',
        'percentage',
        'departing_time',
        'arriving_time',
        'duration',
        'has_wifi',
        'is_direct',
        'is_offer',
        'showcase',
    ];
}
