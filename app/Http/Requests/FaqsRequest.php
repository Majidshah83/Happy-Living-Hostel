<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FaqsRequest extends FormRequest
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
            'answer'         => 'required|string',
            'question'       => 'required|string',
            'status'         => 'required|boolean',
            'category_id'   => 'required',
            'display_order'  => 'required|integer|min:1|digits_between: 1,50'
        ];

    }


}
