<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{

	protected $table = "kod_banners";

    protected $fillable = [
    	'hash_id',
    	'title',
    	'description',
    	'image',
    	'display_order',
    	'status',
    	'created_ip',
    	'updated_ip'
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [

            'title'          => $request->title,
            'description'    => $request->description,
            'display_order'  => $request->display_order,
            'status'         => $request->status,
            'created_ip'     => $request->ip()

        ];

    }

    public static function storeData($request){

        $common_fields = Banner::get_common_fields($request);
        $create_banner = self::firstOrNew( $common_fields );
        if(!empty($create_banner)){
            $create_banner->hash_id =  generateHashId();
            $create_banner->save();
            if($request->file('image')){
                 $create_banner->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'banner', $create_banner->id)]);
            }
            return $create_banner;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = Banner::get_common_fields($request);
        
        $banner = self::where('hash_id', $hash_id)->first();
        
        $banner->update( $common_fields );

        if($request->get('remove_image')){

            if($banner->image != null){

                removeImageDirectory('banner', $banner->image);
                $banner->update(['image' => NULL]);

            }

        }

        if($request->file('image')){
             
            if($banner->image != null){
                removeImageDirectory('banner',$banner->image);
            }
            $banner->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'banner',$banner->id)]);
        
        }

        return $banner;

    }

    public static function deleteData($hash_id){

        $banner = Banner::where('hash_id', $hash_id)->first();

        if($banner->image != null){
            removeImageDirectory('banner', $banner->image);
        }

        return $banner->delete();

    }

}
