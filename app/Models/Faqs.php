<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faqs extends Model
{

	protected $table   = "kod_faqs";

    protected $fillable = [
        "hash_id",
        "category_id",
        "question",
        "answer",
        "display_order",
        "status",
        "created_by_ip",
        "modified_by_ip"
    ];

    public static function get_common_fields($request){

        return [

            'question'       => $request->question,
            'answer'         => $request->answer,
            'display_order'  => $request->display_order,
            'status'         => $request->status,
            'category_id'    => $request->category_id

        ];

    }

    public static function storeData($request){

        $common_fields = Faqs::get_common_fields($request);
        $common_fields['created_by_ip'] = $request->ip();
        $create_faqs = self::firstOrNew( $common_fields );
        if(!empty($create_faqs)){
          $create_faqs['hash_id'] = generateHashId();
          $create_faqs->save();
          return $create_faqs;
        }
        
    }

    public static function updateData($request, $hash_id){

        $common_fields = Faqs::get_common_fields($request);
        $faq = self::where('hash_id', $hash_id)->first();
        $faq->update( $common_fields );
        return $faq;

    }

    public static function deleteData($hash_id){

        return Faqs::where('hash_id', $hash_id)->delete();

    }

}
