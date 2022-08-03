<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
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

        if($this->method() == 'POST'){
          
            return  [
                'title'               => 'required|string',
                'short_description'   => 'nullable|string',
                'long_description'    => 'nullable|string',
                'image'               => 'nullable|image|mimes:mimes:jpg,jpeg,png,bmp,tiffmax:8000',
                'thumbnail'           => 'nullable|image|mimes:mimes:jpg,jpeg,png,bmp,tiff|max:8000',
                'display_order'       => 'required|integer|min:1|digits_between: 1,50',
                'status'              => 'required|boolean',
                'price'               => 'nullable',
                'meta_title'          => 'nullable|string',
                'meta_keywords'       => 'nullable|string',
                'meta_description'    => 'nullable|string'
            ];

        } else {

            return  [
                'title'               => 'required|string',
                'short_description'   => 'nullable|string',
                'long_description'    => 'nullable|string',
                'image'               => 'nullable|image|mimes:mimes:jpg,jpeg,png,bmp,tiff|max:8000',
                'thumbnail'           => 'nullable|image|mimes:mimes:jpg,jpeg,png,bmp,tiff|max:8000',
                'display_order'       => 'required|integer|min:1|digits_between: 1,50',
                'status'              => 'required|boolean',
                'price'               => 'nullable',
                'meta_title'          => 'nullable|string',
                'meta_keywords'       => 'nullable|string',
                'meta_description'    => 'nullable|string',
                'slug'                => 'required'
            ];

        }

    }


}
