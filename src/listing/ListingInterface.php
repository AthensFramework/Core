<?php

namespace Athens\Core\Listing;

use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;

interface ListInterface extends WritableInterface, InitializableInterface
{

    /**
     * @return string
     */
    public function getType();


}
