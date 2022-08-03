<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{

    //

	protected $table   = "kod_services";

    protected $fillable = [
        "hash_id",
        "title",
        "short_description",
        "long_description",
        "price",
        "thumbnail",
        "image",
        "display_order",
        "status",
        "slug",
        "meta_title",
        "meta_keywords",
        "meta_description",
        "position",
        "category",
        "fa_icon",
        "service_url",
        "bookable"
    ];

    public static function get_common_fields($request){

        return [

            "title"             => $request->title,
            "short_description" => $request->short_description,
            "long_description"  => $request->long_description,
            "price"             => $request->price,
            "display_order"     => $request->display_order,
            "status"            => $request->status,
            "slug"              => makeSlug($request->title),
            "meta_title"        => $request->meta_title,
            "meta_keywords"     => $request->meta_keywords,
            "meta_description"  => $request->meta_description,
            "position"           => $request->position,
            "category"          => $request->category,
            "fa_icon"           => $request->fa_icon,
            "service_url"       => $request->service_url,
            "bookable"          => $request->bookable

        ];

    }

    public static function storeData($request){

        $common_fields = Service::get_common_fields($request);
        $create_service = self::firstOrNew( $common_fields );
        if(!empty($create_service)){
            $create_service['hash_id'] = generateHashId();
            $create_service->save();
            if($request->file('image')){
                $create_service->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'services', $create_service->id)]);
            }
            if($request->file('thumbnail')){
                $create_service->update(['thumbnail' => imageSaveDirectory($request->title,$request->file('thumbnail'),'services/thumbnail',$create_service->id)]);
            }
            return $create_service;
        }

    }


    public static function updateData($request, $hash_id){

        $common_fields = Service::get_common_fields($request);
        $service = self::where('hash_id', $hash_id)->first();
      
        if (!$request->get('advanced_settings')) {
            $common_fields['meta_title'] = '';
            $common_fields['meta_keywords'] = '';
            $common_fields['meta_description'] = '';
        }

        $service->update( $common_fields );

        if($request->get('remove_image')){

            if($service->image != null){

                removeImageDirectory('services', $service->image);
                $service->update(['image' => NULL]);

            }

        }

        if($request->get('remove_thumbnail')){

            if($service->thumbnail != null){

                removeImageDirectory('services/thumbnail', $service->thumbnail);
                $service->update(['thumbnail' => NULL]);

            }

        }

        if($request->file('image')){

            if($service->image != null){
                removeImageDirectory('services',$service->image);
            }

            $service->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'services',$service->id)]);

        }

        if($request->file('thumbnail')){

            if($service->thumbnail != null){
                removeImageDirectory('services/thumbnail',$service->thumbnail);
            }

            $service->update(['thumbnail' => imageSaveDirectory($request->title,$request->file('thumbnail'),'services/thumbnail',$service->id)]);

        }

        return $service;

    }


    public static function deleteData($hash_id){

        $service = Service::where('hash_id', $hash_id)->first();

        if($service->image != null){
            removeImageDirectory('services', $service->image);
        }
        if($service->thumbnail != null){
            removeImageDirectory('services/thumbnail', $service->thumbnail);
        }

        return $service->delete();

    }

    /**
     * @Description Add record in banners table.
     */

    public static function store($request){

         $services =[
            "hash_id"           => generateHashId(),
            "title"             => $request->title,
            "short_description" => $request->short_description,
            "long_description"  => $request->long_description,
            "price"             => $request->price,
            "display_order"     => $request->display_order,
            "status"            => $request->status,
            "slug"              => makeSlug($request->title),
            "meta_title"        => $request->meta_title,
            "meta_keywords"     => $request->meta_keywords,
            "meta_description"  => $request->meta_description,
            "position"           => $request->position,
            "category"          => $request->category,
            "fa_icon"           => $request->fa_icon,
            "service_url"       => $request->service_url,
            "bookable"          => $request->bookable
        ];

        $createService = self::create($services);
        if($request->file('image')){
            $createService->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'services',$createService->id)]);
        }
        if($request->file('thumbnail')){
           $createService->update(['thumbnail' => imageSaveDirectory($request->title,$request->file('thumbnail'),'services/thumbnail',$createService->id)]);
        }
        return $createService;

    }

}
