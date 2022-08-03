<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Floor extends Model
{


	protected $table   = "floors";

    protected $fillable = [
    	"hash_id",
        "title"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [
            'title'       => $request->title,
        ];

    }

    public static function storeData($request){

        $common_fields = Floor::get_common_fields($request);
        $create_faq_category = self::firstOrNew( $common_fields );
        if(!empty($create_faq_category)){
            $create_faq_category->hash_id = generateHashId();
            $create_faq_category->save();
            return $create_faq_category;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = Floor::get_common_fields($request);
        $faq_category = self::where('hash_id', $hash_id)->first();
        $faq_category->update( $common_fields );

        return $faq_category;

    }


    public function rooms() {
        return $this->hasMany(Room::class, 'floor_id');
    }

    public static function deleteData($hash_id){

        $banner = self::where('hash_id', $hash_id)->first();


        return $banner->delete();

    }

}
