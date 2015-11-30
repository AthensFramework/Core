<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\FieldBearer\FieldBearer;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Etc\StringUtils;


class PickAForm implements PickAFormInterface {

    /** @var \UWDOEM\Framework\PickA\PickA */
    protected $_pickA;

    /** @var \UWDOEM\Framework\Form\FormAction\FormAction[] */
    protected $_actions;

    /** @var \UWDOEM\Framework\FieldBearer\FieldBearerInterface */
    protected $_fieldBearer;

    protected $_errors = [];

    use VisitableTrait;


    public function getSelectedSlug() {
        $hash = $this->getHash();

        if (array_key_exists($hash, $_POST))
            $slug = $_POST[$hash];
        else {
            $slug = null;
        }

        return $slug;
    }

    /**
     * @return \UWDOEM\Framework\Form\FormInterface
     */
    public function getSelectedForm() {
        $forms = $this->getSubForms();
        $selectedSlug = $this->getSelectedSlug();

        $selectedForm = null;
        foreach ($forms as $key => $form) {
            if ($selectedSlug === StringUtils::slugify($key)) {
                $selectedForm = $form;
                break;
            }
        }

        return $selectedForm;
    }

    public function isValid() {
        $selectedForm = $this->getSelectedForm();

        if (is_null($selectedForm)) {
            $isValid = False;
            $this->addError("You must select an option at left.");
        } else {
            $isValid = $selectedForm->isValid();
        }

        return $isValid;
    }

    public function propagateOnValid() {
        $selectedForm = $this->getSelectedForm();

        $func = [$selectedForm, "onValid"];
        $args = array_merge([$selectedForm], func_get_args());

        call_user_func_array($func, $args);
    }

    public function onValid() {
        $func = [$this, "propagateOnValid"];
        call_user_func_array($func, func_get_args());
    }

    public function onInvalid() {
        $selectedForm  = $this->getSelectedForm();

        if ($selectedForm) {
            $selectedForm->onInvalid();
        }
    }

    public function getHash() {
        return $this->_pickA->getHash();
    }

    public function getFieldBearer() {
        return $this->_fieldBearer;
    }

    public function getErrors() {
        return $this->_errors;
    }

    function getManifest() {
        return $this->_pickA->getManifest();
    }

    function getLabels() {
        return $this->_pickA->getLabels();
    }

    function getWritables() {
        return $this->_pickA->getWritables();
    }

    function getSubForms() {
        return $this->getWritables();
    }

    public function getSubFormByName($name) {
        return $this->getSubForms()[$name];
    }

    function getActions() {
        return $this->_actions;
    }

    function addError($error) {
        $this->_errors[] = $error;
    }

    /**
     * @param array|null $actions
     * @param array $manifest
     */
    public function __construct($manifest, $actions = []) {
        $this->_actions = $actions;
        $this->_pickA = new PickA($manifest);

        $this->_fieldBearer = new FieldBearer([], [], [], [], function() {});
    }

    public function __call($name, $arguments) {
        $selectedForm = $this->getSelectedForm();

        if (!$selectedForm) {
            throw new \Exception("No form selected");
        }
        call_user_func_array([$selectedForm, $name], $arguments);
    }

}