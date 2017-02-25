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

    protected $messages=[];

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
                    $fieldType = 'Email';
                    break;
                    // TODO: more types...
                default:
                    $fieldType = 'Text';
                    break;
            }

            $className = __NAMESPACE__.'\\Field\\'.$fieldType;
            $this->fields[$name] = new $className(
                $name,
                isset($data['label'])? $data['label'] : $name,
                isset($this->postData[$name])? $this->postData[$name] : '',
                isset($data['attr'])? $data['attr'] : []);
        }
    }

    public function isPosted()
    {
        return !empty($this->postData); // TODO
    }

    /////////////////////////////////////////////
    // Validation
    /////////////////////////////////////////////
    public function validate()
    {
        $isValid=true;
        $this->messages = [];
        $lang = $this->config->get('lang');
        foreach ($this->fields as $name => $field) {

            $rules = $this->config->get('field.'.$name.'.rules', []);
            if(empty($rules))continue;

            $validator = new Validate\Validator($name, $field->getLabel(), $rules, $lang);
            if(!$validator->validate($field->value(), $this->postData)) {
                $isValid = false;

                $this->messages[] = $validator->getMessage();
            }
        }
        return $isValid;
    }

    public function getMessages()
    {
        return $this->messages;
    }


    /////////////////////////////////////////////
    // Form tags
    /////////////////////////////////////////////
    public function open($action='', $method='post')
    {
        echo '<form action="'.$action.'" method="'.$method.'">';
    }

    public function submit($value='submit')
    {
        echo '<input type="submit" value="'.$value.'">';
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