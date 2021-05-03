<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class OnlyIntValuesArray implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $valid = true;
        
        array_walk_recursive($value, function ($v) use (&$valid){

            if($v < 0){
                $valid = false;
            } 
        });   

        return $valid; 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The array values are invalid. All values of both arrays must be zero or more.';
    }
}
