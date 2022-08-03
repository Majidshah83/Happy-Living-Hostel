<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PharmacyProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function rules()
    {
              

                $selected_tab = $this->selected_tab; 
                if($selected_tab == "pharmacy_settings" || $selected_tab == "upload_media"){
               
                    return [
                        "meta_title"                => 'nullable|string',
                        "meta_keywords"             => 'nullable|string',
                        "meta_description"          => 'nullable|string',
                        "recaptcha"                 => 'nullable|string',
                        "nhs_url"                   => 'nullable|string',
                        "script_1"                  => 'nullable|string',
                        "script_1"                  => 'nullable|string',
                        "script_1"                  => 'nullable|string',
                        "script_1"                  => 'nullable|string',
                        "logo_1"                    => 'nullable|mimes:jpg,jpeg,png,bmp,tiff,ico',
                        "logo_2"                    => 'nullable|mimes:jpg,jpeg,png,bmp,tiff,ico',
                        "favicon"                   => 'nullable|mimes:jpg,jpeg,png,bmp,tiff,ico',
                        "nhs_logo"                  => 'nullable|mimes:jpg,jpeg,png,bmp,tiff,ico'
                    ];

                

                }else{

                  return [
                    "pharmacy_name"             => 'required|string',
                    "business_name"             => 'nullable|string',
                    "contact_number_primary"    => 'nullable|string',
                    "contact_number_secondary"  => 'nullable|string',
                    "mobile_number"             => 'nullable|string',
                    "whats_number"              => 'nullable|string',
                    "fax_number"                => 'nullable|string',
                    "company_number"            => 'nullable|string',
                    "gphc_reg_number"           => 'nullable|string',
                    "vat_number"                => 'nullable|string',
                    "address_1"                 => 'nullable|string',
                    "address_2"                 => 'nullable|string',
                    "address_3"                 => 'nullable|string',
                    "city"                      => 'nullable|string',
                    "county"                    => 'nullable|string',
                    "post_code"                 => 'nullable|string',
                ];

            }

    }


}
