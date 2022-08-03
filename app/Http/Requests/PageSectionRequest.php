<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageSectionRequest extends FormRequest
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
                'title'             => 'required|string',
                'description'       => 'required|string',
                'status'            => 'required|boolean',
            ];

          } else if ($this->method() == 'PUT') {

                return  [
                    'title'             => 'required|string',
                    'description'       => 'required|string',
                    'status'            => 'required|boolean',
                    'url_slug'          => 'required|string'
                ];

          }

      
    }



}
