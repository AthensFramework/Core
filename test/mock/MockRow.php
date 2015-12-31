<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Row\Row;

class MockRow extends Row
{

    public $saved = false;
    public $savedData = null;

    public function __construct()
    {
    }

    public function setFieldBearer($fieldBearer)
    {
        $this->fieldBearer = $fieldBearer;
    }
}
