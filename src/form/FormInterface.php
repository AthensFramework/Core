<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Initializer\InitializableInterface;


interface FormInterface extends WritableInterface, InitializableInterface {

    /**
     * @return FieldBearerInterface
     */
    function getFieldBearer();

    /**
     * @return FormInterface[]
     */
    function getSubForms();

    /**
     * @param string $name
     * @return FormInterface
     */
    function getSubFormByName($name);

    /**
     * @return bool
     */
    function isValid();

    /**
     * Maybe this should be protected??
     */
    function onValid();

    /**
     * Maybe this should be protected??
     */
    function onInvalid();

    /**
     * @return string[]
     */
    function getErrors();

    /**
     * @return FormAction[]
     */
    function getActions();

    /**
     * @param string $error
     */
    function addError($error);

    function propagateOnValid();

}