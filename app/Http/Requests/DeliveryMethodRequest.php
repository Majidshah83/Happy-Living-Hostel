<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class DeliveryMethodRequest extends FormRequest
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
        
        return [
            'title'          => 'required|string',
            'price'          => 'required|numeric',
            'description'    => 'nullable|string',
            'image'          => 'nullable|image|mimes:mimes:jpg,jpeg,png,bmp,tiff',
            'display_order'  => 'required|integer|min:1|digits_between: 1,50',
            'status'         => 'required|boolean',
            'location'       =>  Rule::in(['Local', 'International'])
        ];

    }
}
