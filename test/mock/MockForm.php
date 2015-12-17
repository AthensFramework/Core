<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Form\Form;

class MockForm extends Form
{

    public $validated = false;
    public $validatedData = null;

    public function isValid()
    {
        return true;
    }

    public function onValid()
    {
        $this->validated = true;

        $this->validatedData = func_num_args() > 0 ? func_get_arg(func_num_args() -1) : null;
    }
}
