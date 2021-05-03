<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ArrayColInAEqualsRowsInB implements Rule
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
        if (
            sizeof($value[0]) 
            && sizeof($value[1]) 
            && count($value[0][1]) == count($value[1])
        ) {
            return true;
        } 
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "Number of columns in the 1st Matirx Must be equal to number of rows in the 2nd Matrix.";
    }
}
