<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RafList extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_raf_list';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id', 'raf_title', 'file_name', 'is_active', 'status', 'notes'
    ];
}
