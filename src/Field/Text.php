<?php

namespace Deveative\EasyForm\Field;

class Text extends Field {

    public function __construct($name, $value, array $attr=[])
    {
        parent::__construct('text', $name, $value, $attr);
    }

    public function getHtml(){
        $attr = $this->getAttrHtml();
        return '<input type="text" name="'.$this->name.'" value="'.$this->value.'"'.$attr.'>';
    }

}