<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethods extends Model
{

    //
	protected $table   = "kod_delivery_methods";

    protected $fillable = [
        "hash_id",
        "title",
        "description",
        "long_description",
        "image",
        "price",
        "display_order",
        "is_international_delivery",
        "status",
        "country",
        "is_international_delivery",
        "created_by_ip",
        "modified_by_ip"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [
            "title"            => $request->title,
            "description"      => $request->description,
            "long_description" => $request->long_description,
            "price"            => $request->price,
            "display_order"    => $request->display_order,
            "is_international_delivery" => $request->location,
            "status"           => $request->status,
            "country"          => $request->country,
            "created_by_ip"    => $request->ip(),
            "modified_by_ip"    => $request->ip(),
        ];

    }

    public static function storeData($request){

        $common_fields = DeliveryMethods::get_common_fields($request);
        $common_fields['hash_id'] = generateHashId();
        $create_delivery_methods = self::create( $common_fields );
        if($request->file('image')){
             $create_delivery_methods->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'deliverymethods', $create_delivery_methods->id)]);
        }
        return $create_delivery_methods;

    }


    public static function updateData($request, $hash_id){

        $common_fields = DeliveryMethods::get_common_fields($request);
        $deliverymethods = self::where('hash_id', $hash_id)->first();
        $deliverymethods->update( $common_fields );

        if($request->get('remove_image')){
            if($deliverymethods->image != null){
                removeImageDirectory('deliverymethods', $deliverymethods->image);
                $deliverymethods->update(['image' => NULL]);
            }
        }

        if($request->file('image')){
            if($deliverymethods->image != null){
                removeImageDirectory('deliverymethods',$deliverymethods->image);
            }
            $deliverymethods->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'deliverymethods',$deliverymethods->id)]);
    
        }
        return $deliverymethods;

    }




}
