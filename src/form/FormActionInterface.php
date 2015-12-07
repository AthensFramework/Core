<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Writer\WritableInterface;

interface FormActionInterface extends WritableInterface
{

    function getMethod();
    
    function getTarget();

    function getLabel();
}
