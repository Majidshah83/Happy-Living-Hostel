<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateImageRule implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */

    private $request;
    private $image_name;

    public function __construct($request, $image_name=false)
    {
        //

        $this->request = $request;
        $this->image = $image_name;

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

            $this->image => ['image', 'max:5120']

        ],

        [

            $this->image.'.image' => ' Please select a valid image',
            $this->image.'.max' => ' File size should be less than 5MB'

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
