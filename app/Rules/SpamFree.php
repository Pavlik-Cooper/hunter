<?php

namespace App\Rules;

use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;

class SpamFree implements Rule
{

    public function passes($attribute, $value)
    {
        try {
            // we expect detect method to return false
            return !resolve(Spam::class)->detect($value);
        }catch (\Exception $e){
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute contains spam.';
    }
}
