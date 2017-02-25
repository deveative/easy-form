<?php

namespace Deveative\EasyForm\Validate\Rule;

interface RuleInterface {

    public static function validate($value, array $postData, array $options);

}