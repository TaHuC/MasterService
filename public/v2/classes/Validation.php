<?php

class Validation {

    private $_passed = false,
            $_errors = array(),
            $_db = null;

    public function __construct() { // vr s bazata
        $this->_db = DB::getInstance();
    }

    public function check($source, $items = array()) {
        foreach ($items as $item => $rules) { // $items sa reg.php usernam, password, pas.... a pravilata sa pod tqh
            foreach ($rules as $rule => $rule_value) {
                $value = $source[$item];

                if ($rule === 'required' && empty($value)) {
                    $this->addErorr("{$item} е празно");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addErorr("{$item} трябва да бъде по голямо от {$rule_value} символа!");
                            }
                            break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addErorr("{$item} трябва да бъде по малко от {$rule_value} символа!");
                            }
                            break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addErorr("{$rule_value} не съвпадат {$item}");
                            }
                            break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addErorr("{$item} вече е заето!");
                            }
                            break;
                    }
                }
            }
        }

        if (empty($this->_errors)) {
            $this->_passed = true;
        }
        return $this;
    }

    private function addErorr($error) {
        $this->_errors[] = $error;
    }

    public function errors() {
        return $this->_errors;
    }

    public function passed() {
        return $this->_passed;
    }

}
