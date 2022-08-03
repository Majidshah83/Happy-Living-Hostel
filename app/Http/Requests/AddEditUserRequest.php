<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditUserRequest extends FormRequest
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
                'first_name'    => 'required|min:2|max:191',
                'last_name'     =>  'required|min:2|max:191',
                'email'         => 'required|string|email|max:90|unique:kod_users,email',
                'role'       => 'required'
            ];

        } else if($this->method() == 'PUT'){

            return [
                'first_name'    => 'required|min:2|max:191',
                'last_name'     =>  'required|min:2|max:191',
                'email'         => 'required|string|email|max:90',
                'role'       => 'required'
            ];
        }
    }

}
