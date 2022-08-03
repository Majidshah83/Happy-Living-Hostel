<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelDetails extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_travel_details';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'passenger_id',
        'date_of_departure',
        'country_id',
        'city_travelled_from',
        'type_of_transport',
        'coach_no',
        'list_countries',
        'arrival_date'
    ];

}
