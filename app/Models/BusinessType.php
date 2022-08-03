<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BusinessType extends Model
{

	protected $table = "kod_business_type";

    protected $fillable = [
    	'hash_id',
    	'title',
    	'order',
        'status'
    ];

 
}
