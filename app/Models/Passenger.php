<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Passenger extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_passengers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id',
        'first_name',
        'surname',
        'dob',
        'gender',
        'ethnicity',
        'vaccination_status',
        'nhs_no',
        'passport_no',
        'phone_no',
        'additional_notes',
        'email'
    ];

}
