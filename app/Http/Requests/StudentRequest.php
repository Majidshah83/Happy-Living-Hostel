<?php

namespace App\Http\Requests;

use App\Rules\ValidateTitlesRule;
use App\Rules\ValidateImageRule;
use Illuminate\Foundation\Http\FormRequest;

class StudentRequest extends FormRequest
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
                'first_name'             => ['required'],
                'last_name'              => 'required',
                'floor'                  => 'required',
                'room'                   => 'required'
            ];

        }else if($this->method() == 'PUT'){
            
            return [
                 'first_name'             => ['required'],
                 'last_name'              => 'required',
                 'floor'                  => 'required',
                 'room'                   => 'required'
            ];

        }

    }

}
