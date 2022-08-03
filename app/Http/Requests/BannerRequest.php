<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Custom Validation Rules
use App\Rules\ValidateTitlesRule;
use App\Rules\ValidateImageRule;

class BannerRequest extends FormRequest
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
            // Add Request
           
            return [
                'title'          => ['required', 'string', new ValidateTitlesRule()],
                'image'          => ['required','image','mimes:jpg,jpeg,png,bmp,tiff','max:8120'],
                'display_order'  => 'required|integer|min:1|digits_between: 1,50',
                'status'         => 'required|boolean'
            ];

        } else if($this->method() == 'PUT') {
            // Edit Request
            
            return [
                'title'          => 'required|string',
                'description'    => 'nullable|string',
                'display_order'  => 'required|integer|min:1|digits_between: 1,50',
                'status'         => 'required|boolean'
            ];

        } // if($this->method() == 'PUT')

    }

//    public function messages(){
//       /* return [
//                'title.required' => 'Title must be banner.',
//        ];*/
//    }


}
