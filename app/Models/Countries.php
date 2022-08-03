<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    /**
     * @var string
     */
    protected $table = 'kod_countries';
    protected $fillable = [
    ];


    public function patients()
    {
        return $this->hasMany(Patient::class, 'country_id');
    }
}
