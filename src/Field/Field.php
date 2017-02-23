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

    /**
     * Print html of element
     */
    public function output() {
        echo $this->getCode();
    }

}