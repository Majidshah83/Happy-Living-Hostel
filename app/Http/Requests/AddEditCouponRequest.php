<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddEditCouponRequest extends FormRequest
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
            'title'                  => 'required',
            'coupon_code'            => 'required',
            'coupon_type'            => 'required',
            'has_expiry'             => 'nullable',
            'expiry_date'            => 'required_if:has_expiry,1',
            'usage_limit'            => 'required|min:1',
            'is_expired'             => 'required|boolean',
            'status'                 => 'required|boolean'
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'expiry_date.required_if' => 'Expiry date is required'
        ];
    }
}
