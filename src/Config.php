<?php

namespace Deveative\EasyForm;

class Config {

    protected $configData;

    /**
     * [__construct description]
     * @param array $config [description]
     */
    public function __construct(array $config=[])
    {
        $this->configData = $config;
    }

    /**
     * Get configured data by key
     * @param  string $key     config key
     * @param  mixed  $default return value if not has key (default: null)
     * @return mixed           configured value or default value
     */
    public function get($key=null, $default=null)
    {
        if($key===null)return $this->configData;

        $indexes = explode('.', $key);
        $c=$this->configData;
        foreach ($indexes as $idx) {
            if(is_array($c)) {
                if(!array_key_exists($idx, $c))return $default;
                $c=$c[$idx];
            }
        }
        return $c;
    }

    /**
     * Set config
     * @param string $key   key
     * @param mixed  $value value
     */
    public function set($key, $value)
    {
        $indexes = explode('.', $key);
        $lastIndex = array_pop($indexes);
        $c =& $this->configData;
        foreach ($indexes as $idx) {
            if(!isset($c[$idx]) || !is_array($c[$idx])
                 || !array_key_exists($idx, $c)) {
                $c[$idx]=[];
            }

            $c =& $c[$idx];
        }
        $c[$lastIndex] = $value;
    }
}