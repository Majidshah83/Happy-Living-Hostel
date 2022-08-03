<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{

    /**
     * @var string
     */
    protected $table = 'kod_user_types';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'hash_id', 'title', 'code', 'is_prescriber', 'description', 'display_order', 'status',
        'modified_by_id', 'created_by_ip', 'modified_by_ip', 'created_by_id'
    ];

    /**
     * @param $user_type_hash_id
     *
     * @return mixed
     * @description Return user type instance
     */
    public static function hashedUserType($user_type_hash_id)
    {
        return self::where('hash_id', '=', $user_type_hash_id)->first();
    }

    /**
     * Get the user that owns the user type.
     */
//    public function user()
//    {
//        return $this->belongsTo(User::class);
//    }

//    public function user(){
//        return $this->hasOne(User::class, 'user_type_id');
//    }

    /**
     * Get the users for the user type.
     */
    public function users()
    {
        return $this->hasMany(User::class, 'user_type_id');
    }



}
