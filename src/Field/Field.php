<?php

namespace Deveative\EasyForm\Field;

abstract class Field {

    /** @var string field type attribute */
    protected $type='';

    /** @var string field name attribute */
    protected $name='';

    /** @var string field name(for render) */
    protected $label='';

    /** @var string field value */
    protected $value='';

    /** @var array additional attributes */
    protected $attr=[];

    /**
     * Get html of input-field
     * @return string       tag code
     */
    abstract public function getHtml();

    public function __construct($type, $name, $label, $value, array $attr=[])
    {
        $this->type = $type;
        $this->name = $name;
        $this->label = $label;
        $this->value = $value;
        $this->attr = $attr;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function value()
    {
        return $this->value;
    }

    /**
     * Print html of element
     */
    public function render() {
        echo $this->getHtml();
    }

    public function __toString()
    {
        return $this->value;
    }

    public function getAttrHtml()
    {
        $attr = '';
        foreach ($this->attr as $k => $v) {
            $attr .= ' '.$k.'="'.$v.'"';
        }
        return $attr;
    }

}