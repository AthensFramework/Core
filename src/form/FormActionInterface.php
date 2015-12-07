<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Writer\WritableInterface;

interface FormActionInterface extends WritableInterface
{

    public function getMethod();

    public function getTarget();

    public function getLabel();
}
