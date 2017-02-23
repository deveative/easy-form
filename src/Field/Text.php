<?php

namespace Deveative\EasyForm\Field;

class Text extends Field {

    protected function getCode(){
        // TODO more attributes..
        return '<input type="text" name="'.$this->name.'">';
    }

}