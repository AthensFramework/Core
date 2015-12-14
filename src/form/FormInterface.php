<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Initializer\InitializableInterface;

interface FormInterface extends WritableInterface, InitializableInterface
{
    /**
     * @return string
     */
    public function getType();

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
     * Maybe this should be protected??
     */
    public function onValid();

    /**
     * Maybe this should be protected??
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
     */
    public function addError($error);

    public function propagateOnValid();
}
