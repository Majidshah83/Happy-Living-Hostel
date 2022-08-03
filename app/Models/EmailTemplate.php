<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{


	protected $table   = "kod_email_templates";

    protected $fillable = [
    	"hash_id",
        "email_title",
        "email_subject",
        "email_body",
        "status",
        "created_by_ip",
        "modified_by_ip"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function get_common_fields($request){

        return [
            'email_title'       => $request->email_title,
            'email_subject'     => $request->email_subject,
            'email_body'        => $request->email_body,
            'status'            => $request->status,
            'created_by_ip'     => $request->ip(),
            'modified_by_ip'    => $request->ip()
        ];

    }

    public static function storeData($request){
         
        $common_fields = EmailTemplate::get_common_fields($request);
        $create_email_template = self::firstOrNew( $common_fields );
        if(!empty($create_email_template)){

          $create_email_template['hash_id'] = generateHashId();  
          $create_email_template->save();
          return $create_email_template;
          
        }

    }

    public static function updateData($request, $hash_id){

        $common_fields = EmailTemplate::get_common_fields($request);
        $email_template = self::where('hash_id', $hash_id)->first();
        $email_template->update( $common_fields );
        
        return $email_template;

    }

    public static function deleteData($hash_id){

        $email_template = EmailTemplate::where('hash_id', $hash_id)->first();

        return $email_template->delete();

    }

}
