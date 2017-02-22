<?php

namespace Deveative\EasyForm;

use \PHPMailer\PHPMailer;

/**
* EasyForm
*/
class EasyForm {

    /** @var array user posted data */
    protected $postData;

    /** @var Deveative\EasyForm\Config settings */
    protected $config;

    function __construct(array $postData=[], $config=[])
    {
        if(!(is_array($config) || $config instanceof Config)){
            throw new InvalidArgumentException(
                'Argument "config" is allow Array or Deveative\EasyForm\Config');
        }

        $this->postData = $postData;
        $this->config = is_array($config) ? new Config($config) : $config;
    }
}