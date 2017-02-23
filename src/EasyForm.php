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

    /** @var array form fields */
    protected $fields;

    function __construct(array $config=[], array $postData=[])
    {
        if(!(is_array($config) || $config instanceof Config)){
            throw new InvalidArgumentException(
                'Argument "config" is allow Array or Deveative\EasyForm\Config');
        }

        $this->postData = $postData;
        $this->config = is_array($config) ? new Config($config) : $config;
        $this->loadFields();
    }

    protected function loadFields(){
        $this->fields = [];
        $fields = $this->config->get('field', []);
        foreach ($fields as $name => $data) {
            switch (@$data['type']) {
                case 'email':
                    $fieldType = 'Field\\Email';
                    break;
                    // TODO: more types...
                default:
                    $fieldType = 'Field\\Text';
                    break;
            }

            $this->fields[$name] = new Field\Text(
                $name,
                isset($this->postData[$name])? $this->postData[$name] : '',
                isset($data['attr'])? $data['attr'] : []);
                // TODO: Set Class Field\XXX from variable
        }
    }

    /////////////////////////////////////////////
    // Form tags
    /////////////////////////////////////////////
    public function open($action='')
    {
        echo '<form action="'.$action.'">';
    }

    public function close()
    {
        echo '</form>';
    }

    /////////////////////////////////////////////
    // MagicMethods for Fields
    /////////////////////////////////////////////
    public function __get($name)
    {
        if(isset($this->fields[$name])){
            return $this->fields[$name];
        }

        return null;
    }

    public function __call($name, array $arguments)
    {
        if(isset($this->fields[$name])){
            $this->fields[$name]->render();
        }
    }
}