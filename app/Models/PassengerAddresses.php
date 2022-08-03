<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PassengerAddresses extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_passenger_addresses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'passenger_id',
        'b_first_name',
        'b_surname',
        'b_postcode',
        'b_city',
        'b_address',
        'd_first_name',
        'd_surname',
        'd_postcode',
        'd_city',
        'd_address',
        'uk_address',
        'uk_postcode',
        'uk_city',
    ];

}
