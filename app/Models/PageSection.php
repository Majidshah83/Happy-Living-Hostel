<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageSection extends Model
{

    //

	protected $table   = "kod_page_sections";

    protected $fillable = [
        "hash_id","title","url_slug","description","status"
    ];


    /**
     * @Description Add record in page section table.
     */

    public static function get_common_fields($request){

        return [
            'title'          => $request->title,
            'description'    => $request->description,
            'status'         => $request->status
        ];

    }


    public static function storeData($request){

        $common_fields = PageSection::get_common_fields($request);
        $common_fields['url_slug'] = makeSlug($request->title);
        $create_page_Section = self::firstOrNew( $common_fields );
        if(!empty($create_page_Section)){
            $create_page_Section['hash_id'] = generateHashId(); 
            $create_page_Section->save();
            return $create_page_Section;
        }

    }


    public static function updateData($request, $hash_id){

        $common_fields = PageSection::get_common_fields($request);
        $common_fields['url_slug']  = makeSlug($request->url_slug);
        $PageSection = self::where('hash_id', $hash_id)->first();
        $PageSection->update( $common_fields);
        return $PageSection;

    }


}
