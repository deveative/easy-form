<?php

namespace Deveative\EasyForm\Field;

class Textarea extends Field {

    protected $defaultCols = 80;

    protected $defaultRows = 10;

    public function __construct($name, $label, $value, array $attr=[])
    {
        parent::__construct('textarea', $name, $label, $value, $attr);
        if(!isset($attr['cols']))$this->attr['cols']=$this->defaultCols;
        if(!isset($attr['rows']))$this->attr['rows']=$this->defaultRows;
    }

    public function getHtml(){
        $attr = $this->getAttrHtml();
        return '<textarea name="'.$this->name.'"'.$attr.'>'.$this->value.'</textarea>';
    }

}