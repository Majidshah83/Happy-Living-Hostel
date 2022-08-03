<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateFileRule implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $request;
    private $file_name;

    public function __construct($request, $file_name=false)
    {
        //

        $this->request = $request;
        $this->file_name = $file_name;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
    */

    public function passes($attribute, $value)
    {
    
        // return $value === 'image',
        return $this->request->validate([

            $this->file_name => ['mimes:jpg,jpeg,png,gif,pdf,doc,docm,docx,csv,xls,xlsx', 'max:5120']

        ],

        [

            $this->file_name.'.mimes' => ' Allowed file types are: jpg, jpeg, png, gif, pdf, doc, docm, docx, csv, xls, xlsx',
            $this->file_name.'.max' => ' File size should be less than 5MB'

        ]);

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not using this message';
    }
}
