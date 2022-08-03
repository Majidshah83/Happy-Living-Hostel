<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PharmacySettings extends Model
{

    //
	protected $table   = "kod_pharmacy_settings";

    protected $fillable = [
        "meta_title",
        "meta_keywords",
        "meta_description",
        "recaptcha",
        "nhs_url",
        "script_1",
        "script_2",
        "script_3",
        "script_4",
        "logo_1",
        "logo_2",
        "favicon",
        "nhs_logo",
        "created_by_ip",
        "modified_by_ip"
    ];

    /**
     * @Description Add record in banners table.
     */

    public static function storeData($request){

         $pharmcayInfo = [
            "meta_title"        => $request->meta_title,
            "meta_keywords"     => $request->meta_keywords,
            "meta_description"  => $request->meta_description,
            "recaptcha"         => $request->recaptcha,
            "nhs_url"           => $request->nhs_url,
            "script_1"          => $request->script_1,
            "script_2"          => $request->script_2,
            "script_3"          => $request->script_3,
            "script_4"          => $request->script_4,
            "created_by_ip"     => $request->ip(),
            "modified_by_ip"   =>  $request->ip()
        ];

        $createUpdatePharmcayInfo = self::first();
        if($createUpdatePharmcayInfo){
           $createUpdatePharmcayInfo->update($pharmcayInfo);
        }else{
           $createUpdatePharmcayInfo = self::create($pharmcayInfo);
        }
    
        if($request->file('logo_1')){ 
            
           removeImageDirectory('pharmacyprofile', $createUpdatePharmcayInfo->logo_1);
           $createUpdatePharmcayInfo->update(['logo_1' => imageSaveDirectory("logo_1",$request->file('logo_1'),'pharmacyprofile',$createUpdatePharmcayInfo->id)]);

        }
        if($request->file('logo_2')){ 
           removeImageDirectory('pharmacyprofile', $createUpdatePharmcayInfo->logo_2);
           $createUpdatePharmcayInfo->update(['logo_2' => imageSaveDirectory("logo_2",$request->file('logo_2'),'pharmacyprofile',$createUpdatePharmcayInfo->id)]);
        }
        if($request->file('favicon')){ 
           removeImageDirectory('pharmacyprofile', $createUpdatePharmcayInfo->favicon);  
           $createUpdatePharmcayInfo->update(['favicon' => imageSaveDirectory("favicon",$request->file('favicon'),'pharmacyprofile',null)]);
        }
        if($request->file('nhs_logo')){ 
          removeImageDirectory('pharmacyprofile', $createUpdatePharmcayInfo->nhs_logo);  
           $createUpdatePharmcayInfo->update(['nhs_logo' => imageSaveDirectory("nhs_logo",$request->file('nhs_logo'),'pharmacyprofile',$createUpdatePharmcayInfo->id)]);
        }
        if($request->checkbox_logo_1){
            removeImageDirectory('pharmacyprofile',$createUpdatePharmcayInfo->logo_1);
            $createUpdatePharmcayInfo->update(['logo_1' => null]);
        }
        if($request->checkbox_logo_2){
            removeImageDirectory('pharmacyprofile',$createUpdatePharmcayInfo->logo_2);
            $createUpdatePharmcayInfo->update(['logo_2' => null]);
        }
        if($request->checkbox_favicon){
            removeImageDirectory('pharmacyprofile',$createUpdatePharmcayInfo->favicon);
            $createUpdatePharmcayInfo->update(['favicon' => null]);
        }
        if($request->checkbox_nhs_logo){
            removeImageDirectory('pharmacyprofile',$createUpdatePharmcayInfo->nhs_logo);
            $createUpdatePharmcayInfo->update(['nhs_logo' => null]);
        }
        return $createUpdatePharmcayInfo;

    }



}
