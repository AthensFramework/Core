<?php

use UWDOEM\Framework\FieldBearer\FieldBearer;
use UWDOEM\Framework\Form\Form;

class MockFieldBearer extends FieldBearer {

    public $saved = false;
    public $savedData = null;

    public function __construct() {}

    public function save() {
        $this->saved = true;

        $this->savedData = func_num_args() > 0 ? func_get_arg(func_num_args() -1) : null;
    }
}

class MockForm extends Form {

    public $validated = false;
    public $validatedData = null;

    public function isValid() {
        return true;
    }

    public function onValid() {
        $this->validated = true;

        $this->validatedData = func_num_args() > 0 ? func_get_arg(func_num_args() -1) : null;
    }
}