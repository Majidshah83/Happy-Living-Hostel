<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditStaffRequest extends FormRequest
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
                'first_name'    => 'required',
                'last_name'     =>  'required',
                'email'         => 'required|string|email|max:90|unique:kod_users,email',
                'user_type_id'  => 'required|exists:kod_user_types,id',
                'address_1'       => 'required',
                'postcode'       => 'required',
                'city'       => 'required',
                'role'       => 'required'
            ];

        } else if($this->method() == 'PUT'){

            return [
                'first_name'    => 'required',
                'last_name'     =>  'required',
                'email'         => 'required|string|email|max:90',
                'user_type_id'  => 'required|exists:kod_user_types,id',
                'address_1'     => 'required',
                'postcode'      => 'required',
                'city'          => 'required',
                'role'          => 'required'
            ];
        }
    }
}
