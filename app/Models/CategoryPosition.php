<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryPosition extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_category_positions';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id', 'title', 'display_order', 'status'
    ];
}
