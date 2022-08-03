<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditPatientRequest extends FormRequest
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
                'first_name'      => 'required',
                'last_name'       =>  'required',
                'email'           => 'required|string|email|max:90|unique:kod_patients,email',
                'gender'          => 'required|string',
                'day'             => 'required',
                'month'           => 'required',
                'year'            => 'required',
                'passport_number' => 'required',
                'address'       => 'required',
                'town_city'       => 'required',
                'postcode'        => 'required'
            ];
        } else if($this->method() == 'PUT'){

            return [
                'first_name'      =>   'required',
                'last_name'       =>   'required',
                'email'           =>   'required|string|email|max:90',
                'gender'          =>   'required|string',
                'day'             =>   'required',
                'month'           =>   'required',
                'year'            =>   'required',
                'passport_number' =>   'required',
                'address'       =>   'required',
                'town_city'       =>   'required',
                'postcode'        =>   'required'
            ];

        }

    }
}
