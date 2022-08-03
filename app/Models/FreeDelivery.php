<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FreeDelivery extends Model
{

    //
	protected $table   = "kod_free_delivery";

    protected $fillable = [
        "is_delivery_free",
        "minimum_amount",
    ];

   

}
