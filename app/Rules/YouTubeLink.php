<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class YouTubeLink implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $regex = "/(youtube.com|youtu.be)\/(watch)?(\?v=)?(\S+)?/";

        return preg_match($regex, $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be a valid YouTube link.';
    }
}
