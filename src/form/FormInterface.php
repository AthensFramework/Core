<?php

namespace Athens\Core\Form;

use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\Form\FormAction\FormAction;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Initializer\InitializableInterface;

interface FormInterface extends WritableInterface, InitializableInterface
{

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer();

    /**
     * @return FormInterface[]
     */
    public function getSubForms();

    /**
     * @param string $name
     * @return FormInterface
     */
    public function getSubFormByName($name);

    /**
     * @return boolean
     */
    public function isValid();

    /**
     * @return void
     */
    public function onValid();

    /**
     * @return void
     */
    public function onInvalid();

    /**
     * @return string[]
     */
    public function getErrors();

    /**
     * @return FormAction[]
     */
    public function getActions();

    /**
     * @param string $error
     * @return void
     */
    public function addError($error);

    /**
     * @return void
     */
    public function propagateOnValid();
}
