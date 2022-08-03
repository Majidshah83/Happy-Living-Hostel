<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{

    protected $table = "kod_pharmacy_categories";

    protected $fillable = [
        'hash_id',
        'title',
        'description',
        'image',
        'slug',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'display_order',
        'status',
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [

            'title'            => $request->title,
            'description'      => $request->description,
            'display_order'    => $request->display_order,
            'status'           => $request->status,
            "meta_title"       => $request->meta_title,
            "meta_keywords"    => $request->meta_keywords,
            "meta_description" => $request->meta_description

        ];

    }

    public static function storeData($request){

        $common_fields = BlogCategory::get_common_fields($request);
        $create_blog = self::firstOrNew( $common_fields );
        if(!empty($create_blog)){
            $create_blog->hash_id =  generateHashId();
            $create_blog->slug    =  makeSlug($request->title);
            $create_blog->save();
            if($request->file('image')){
                 $create_blog->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'category', $create_blog->id)]);
            }
            return $create_blog;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = BlogCategory::get_common_fields($request);

        $blog = self::where('hash_id', $hash_id)->first();
        $common_fields['slug'] = makeSlug($request->slug);
        $blog->update( $common_fields );
        if($request->get('remove_image')){
            if($blog->image != null){
                removeImageDirectory('category', $blog->image);
                $blog->update(['image' => NULL]);
            }
        }

        if($request->file('image')){
             
            if($blog->image != null){
                removeImageDirectory('category',$blog->image);
            }
            $blog->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'category',$blog->id)]);
    
        }
        return $blog;

    }

    public static function deleteData($hash_id){

        $blog = BlogCategory::where('hash_id', $hash_id)->first();
        if($blog->image != null){
            removeImageDirectory('category', $blog->image);
        }
        return $blog->delete();

    }

}
