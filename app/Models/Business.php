<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{

	protected $table = "kod_business";

    protected $fillable = [
    	'hash_id',
    	'business_type_id',
    	'business_name',
    	'address_1',
    	'address_2',
    	'address_3',
    	'town_city',
    	'county',
        'postcode',
        'opening_hour',
        'notification',
        'website_url',
        'status',
        'display_order'
    ];

    public function Type()
    {
       return $this->hasOne('App\Models\BusinessType','id','business_type_id');
    }


    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [

            'business_type_id' =>  $request->business_type_id,
            'business_name'    =>  $request->business_name,
            'address_1'        =>  $request->address_1,
            'address_2'        =>  $request->address_2,
            'address_3'        =>  $request->address_3,
            'town_city'        =>  $request->town_city,
            'county'           =>  $request->county,
            'postcode'         =>  $request->postcode,
            'opening_hour'     =>  $request->opening_hour,
            'notification'     =>  $request->notification,
            'website_url'      =>  $request->website_url,
            'display_order'    =>  $request->display_order,
            'status'           =>  $request->status  

        ];

    }

    public static function storeData($request){

        $common_fields = Business::get_common_fields($request);
        $create_business = self::firstOrNew( $common_fields );
        if(!empty($create_business)){
            $create_business->hash_id =  generateHashId();
            $create_business->save();
            return $create_business;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = Business::get_common_fields($request);
        $business = self::where('hash_id', $hash_id)->first();
        $business->update( $common_fields );
        return $business;

    }

    /*  public static function deleteData($hash_id){
        $banner = Banner::where('hash_id', $hash_id)->first();
        if($banner->image != null){
            removeImageDirectory('banner', $banner->image);
        }
        return $banner->delete();
    }*/

}
