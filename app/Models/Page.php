<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{


	protected $table   = "kod_pages";

    protected $fillable = [
    	"hash_id","title","url_slug","description","image","meta_title","meta_keywords","meta_description","status","created_by_ip","modified_by_ip","advanced_settings"
    ];

    /**
     * @Description Add record in pages table.
     */

    public static function get_common_fields($request){

        return [

            'title'             => $request->title,
            'description'       => $request->description,
            'status'            => $request->status,
            'meta_title'        => $request->meta_title,
            'meta_keywords'     => $request->meta_keywords,
            'meta_description'  => $request->meta_description,

        ];

    }

    public static function storeData($request){

        $common_fields              = Page::get_common_fields($request);
        $common_fields['url_slug']  = makeSlug($request->title);
        $common_fields['created_by_ip'] = $request->ip();
        $create_page = self::firstOrNew( $common_fields );
        if(!empty($create_page)){
            $create_page['hash_id']   = generateHashId();
            $create_page->save();
            if($request->file('image')){
                $create_page->update(['image' => imageSaveDirectory($request->title, $request->file('image'), 'page', $create_page->id)]);
            }
            return $create_page;
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = Page::get_common_fields($request);
        $common_fields['url_slug']  = makeSlug($request->url_slug);
        $page = self::where('hash_id', $hash_id)->first();
        $page->update( $common_fields );
        if($request->get('remove_image')){
            if($page->image != null){
                removeImageDirectory('page', $page->image);
                $page->update(['image' => NULL]);
            }
        }

        if($request->file('image')){
            if($page->image != null){
                removeImageDirectory('page',$page->image);
            }
            $page->update(['image' => imageSaveDirectory($request->title,$request->file('image'),'page',$page->id)]);
        }

        return $page;

    }


    public static function deleteData($hash_id){

        $page = Page::where('hash_id', $hash_id)->first();
        if($page->image != null){
            removeImageDirectory('page', $page->image);
        }
        return $page->delete();

    }



}
