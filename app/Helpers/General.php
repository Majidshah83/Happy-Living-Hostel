<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Models\PharmacySettings;
use App\Models\PageSection;

   /**
     * @param string $url_slug
     * @return string
     */
    function getPageSection($url_slug = ""): string
    {
        $pageSection = PageSection::where('url_slug', $url_slug)->first();
        if($pageSection && !empty($pageSection->description)) {
            return $pageSection->description;
        }
        return "";
    }


     /**
      * @return string
      * @description returns hash_id
     */

    function generateHashId()
    {
      
        $get_time_with_mille = new DateTime();
        $str_time = strtotime($get_time_with_mille->format("Y-m-d H:i:s.v")); 
        return Str::random(6).''.$str_time;
        
    }

    function checkSpaceRoom($space,$room_id){

      $student =DB::table('students')->where('room_id',$room_id)->where('status',1)->get()->count();

      if($student > 0){
          $space = $space-$student;
      }
      return $space;

    }

    /**
     * Image save in directory
     * @param $request,
     * @param $path,
     * @param $id
     * return $file_name
    */

    function imageSaveDirectory($title,$image,$path=null,$id=null){

        $name = makeSlug($title);
        $file_name  = (pathinfo($name));
        if($id == null){
         
                  $file  = $name.'.'.$image->getClientOriginalExtension();

        }else{

              $file  = $name.'-'.$id.'.' .$image->getClientOriginalExtension();

        }
        Storage::disk('public')->putFileAs($path, $image, $file);
        return $file;

    }

    /**
     * Make slug in title.
    */

    function makeSlug($title){
        return  Str::slug($title); 
    }

    /**
     * @param $email
     * @return string
     */

    function trimEmail($email) {
        return strtolower(trim($email));
    }

    function removeImageDirectory($dir,$name){

        if (Storage::disk('public')->exists('/'.$dir.'/'.$name)){
           Storage::disk('public')->delete('/'.$dir.'/'.$name);
        }

    }

    function validateCaptcha($data) {
        return Validator::make(
            $data,
            [ 'g-recaptcha-response' => 'required' ],
            [ 'required' => 'Please verify captcha.' ]
        );
    }

    function getRecaptacha(){

       $pharmacy_settings = PharmacySettings::first();
       return $pharmacy_settings->recaptcha; 
    
    }

    function addressConcatnateWithComma($address,$patient_address){

      $address .= $patient_address->address ?  $patient_address->address : '';
      $address .= $patient_address->town_city ?  ', '.$patient_address->town_city : '';
      $address .= $patient_address->postcode  ?  ', '.$patient_address->postcode : '';
      return $address;
      
    }
   
    function addressWithComma($patient_address){
      
      $address = '';
      $address = addressConcatnateWithComma($address,$patient_address);
      return $address;
           
   }


?>
