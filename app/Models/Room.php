<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{

	protected $table   = "rooms";

    protected $fillable = [
        "hash_id",
        "floor_id",
        "room_name",
        "capacity"
    ];

    public static function get_common_fields($request){

        return [

            'floor_id'       => $request->floor_id,
            'room_name'         => $request->room_name,
            'capacity'  => $request->capacity

        ];

    }

    public static function storeData($request){

        $common_fields = Room::get_common_fields($request);
        $create_faqs = self::firstOrNew( $common_fields );
        if(!empty($create_faqs)){
          $create_faqs['hash_id'] = generateHashId();
          $create_faqs->save();
          return $create_faqs;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = Room::get_common_fields($request);
        $faq = self::where('hash_id', $hash_id)->first();
        $faq->update( $common_fields );
        return $faq;

    }

    public static function deleteData($hash_id){

        return Room::where('hash_id', $hash_id)->delete();

    }

    public function floor() {
        return $this->belongsTo(Floor::class, 'floor_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class,'id','room_id');
    }

}