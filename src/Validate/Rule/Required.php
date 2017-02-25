<?php

namespace Deveative\EasyForm\Validate\Rule;

class Required implements RuleInterface {

    public static function validate($value, array $postData, array $options)
    {
        if(is_array($value)){
            return !empty($value);
        }

        return isset($value) && mb_strlen($value) > 0;
    }

}