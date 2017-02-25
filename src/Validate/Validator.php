<?php

namespace Deveative\EasyForm\Validate;

class Validator {

    protected $rules=[];
    protected $validated=false;
    protected $message=null;
    protected $lang;

    protected $fieldName='';
    protected $fieldLabel='';

    public function __construct($fieldName, $fieldLabel, array $rules=[], $language='English')
    {
        $this->fieldName = $fieldName;
        $this->fieldLabel = $fieldLabel;
        $this->rules = $rules;
        $this->lang = $language;
    }

    public function isValid()
    {
        if(!$this->validated)$this->validate();
        return !isset($this->message);
    }

    public function validate($value, array $postData)
    {
        $this->validated=true;
        foreach ($this->rules as $ruleName => $rule) {
            if(!is_array($rule))$rule=[];
            $v = $this->getRuleClass($ruleName);
            if(!$v::validate($value, $postData, $rule)){
                $msg = isset($rule['msg']) ? $rule['msg'] : $this->getDefaultMessage($ruleName);
                $this->message = $this->buildMessage($msg, $rule);
            }
        }

        return $this->isValid();
    }

    protected function buildMessage($msg, array $placeHolders=[])
    {
        $defaultPlaceholders = [
            'name'  => $this->fieldName,
            'label' => $this->fieldLabel,
        ];
        $placeHolders = array_merge($defaultPlaceholders, $placeHolders);
        foreach ($placeHolders as $k => $v) {
            $msg = str_replace(':'.$k, $v, $msg);
        }
        return $msg;
    }

    public function getMessage()
    {
        return $this->message;
    }

    protected function getDefaultMessage($ruleName)
    {
        $className = __NAMESPACE__.'\\Message\\'.$this->lang;
        $constName = ucfirst($ruleName);
        return constant("$className::$constName");
    }

    protected function getRuleClass($ruleName)
    {
        return __NAMESPACE__.'\\Rule\\'.ucfirst($ruleName);
    }

}