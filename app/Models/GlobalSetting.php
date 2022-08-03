<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GlobalSetting extends Model
{

    //
    
	protected $table   = "kod_global_settings";

    protected $fillable = [
        "hash_id",
        "setting_title",
        "setting_value",
        "setting_key",
    ];

    public static function get_common_fields($request){

           return  [
                "setting_title" => $request->setting_title,
                "setting_value" => $request->setting_value,
                "setting_key"   => $request->setting_key
            ];

    }

    
    public static function storeData($request){

        $common_fields            = GlobalSetting::get_common_fields($request);
        $global_setting           = self::firstOrNew( $common_fields );
        if(!empty($global_setting)){
          $global_setting['hash_id'] = generateHashId();  
          $global_setting->save();
          return $global_setting;            
        }


    }

    public static function updateData($request, $hash_id){

        $common_fields = GlobalSetting::get_common_fields($request);
        $settings = self::where('hash_id', $hash_id)->first();
        $settings->update( $common_fields );

        return $settings;

    }


}
