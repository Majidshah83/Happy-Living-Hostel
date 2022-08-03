<?php

namespace App\Http\Requests;

use App\Rules\ValidateTitlesRule;
use App\Rules\ValidateImageRule;
use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
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
            
            return [
                'title'             => ['required','string','unique:kod_pages,title', new ValidateTitlesRule()],
                'description'       => 'required|string',
                'image'             => ['nullable','image','mimes:mimes:jpg,jpeg,png,bmp,tiff','max:8120'],
                'status'            => 'required|boolean'
            ];

        }else if($this->method() == 'PUT'){
            
            return [
                'title'             => ['required', 'string', new ValidateTitlesRule()],
                'description'       => 'required|string',
                'url_slug'          => 'required',
                'image'             => ['nullable','image','mimes:mimes:jpg,jpeg,png,bmp,tiff','max:8120'],
                'status'            => 'required|boolean'
            ];

        }

    }

}
