<?php

namespace Deveative\EasyForm\Field;

class Text extends Field {

    public function __construct($name, $label, $value, array $attr=[])
    {
        parent::__construct('text', $name, $label, $value, $attr);
    }

    public function getHtml(){
        $attr = $this->getAttrHtml();
        return '<input type="text" name="'.$this->name.'" value="'.$this->value.'"'.$attr.'>';
    }

}