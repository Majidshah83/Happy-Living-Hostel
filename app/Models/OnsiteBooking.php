<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OnsiteBooking extends Model
{
    protected $table = "kod_onsite_booking";

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'test_required',
        'status',
        'arrival_date',
    ];
}
