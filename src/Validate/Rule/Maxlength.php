<?php

namespace Deveative\EasyForm\Validate\Rule;

class Maxlength implements RuleInterface {

    public static function validate($value, array $postData, array $options)
    {
        assert(isset($options['length']));

        $length = $options['length'];

        if(is_array($value)) {
            return count($value) <= $length;
        }

        return mb_strlen($value) <= $length;
    }

}