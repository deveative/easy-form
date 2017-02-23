<?php

namespace Deveative\EasyForm\Field;

abstract class Field {

    /** @var string field type attribute */
    protected $type='';

    /** @var string field name attribute */
    protected $name='';

    /** @var string field value */
    protected $value='';

    /** @var array additional attributes */
    protected $attr=[];

    /**
     * Get html of input-field
     * @return string       tag code
     */
    abstract protected function getCode();

    public function __construct($type, $name, $value, array $attr=[])
    {
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
        $this->attr = $attr;
    }

    /**
     * Print html of element
     */
    public function output() {
        echo $this->getCode();
    }

    public function __toString()
    {
        return $this->value;
    }
}