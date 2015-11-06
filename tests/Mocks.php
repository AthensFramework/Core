<?php

use UWDOEM\Framework\FieldBearer\FieldBearer;

class MockFieldBearer extends FieldBearer {

    public $saved = false;

    public function __construct() {}

    public function save() {
        $this->saved = true;
    }
}