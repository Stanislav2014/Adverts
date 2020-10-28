<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Helpers\Advert\Advert;

class AdvertRule implements Rule
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

    //todo валидация и фильтр картинок которые не попадут под regex ли вадиация всех картинок и если одна из
    //todo них не попадает под регулярку то запрос не проходит валидацию.

    public function passes($attribute, $images)
    {
        if (!is_array($images)) {
            return false;
        }

        // Проверка на индексированный массив

        if (!isset($images[0])) {
            return false;
        }
        foreach ($images as $image) {
            if (!@file_get_contents($image, false, null, null, 1)) {
                return false;
            }
        }

        $count = count($images);
        return $count && $count < 4;

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Not supported type or not images or images more than three';
    }
}
