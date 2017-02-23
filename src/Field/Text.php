<?php

namespace Deveative\EasyForm\Field;

class Text extends Field {

    public function __construct($name, $value, array $attr=[])
    {
        parent::__construct('text', $name, $value, $attr);
    }

    protected function getCode(){
        // TODO more attributes..
        return '<input type="text" name="'.$this->name.'">';
    }

}