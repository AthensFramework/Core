<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\FieldBearer\FieldBearer;

class MockFieldBearer extends FieldBearer
{

    public $saved = false;
    public $savedData = null;

    public function __construct()
    {
    }

    public function save()
    {
        $this->saved = true;

        $this->savedData = func_num_args() > 0 ? func_get_arg(func_num_args() -1) : null;
    }
}
