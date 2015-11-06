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

    use VisitableTrait;


    protected function getSelectedSlug() {
        if (array_key_exists($this->getHash(), $_POST))
            $slug = $_POST[$this->getHash()];
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
        } else {
            $isValid = $selectedForm->isValid();
        }

        return $isValid;
    }

    public function onValid() {
        $this->getSelectedForm()->onValid();
    }

    public function onInvalid() {
        $this->getSelectedForm()->onInvalid();
    }

    public function getHash() {
        return $this->_pickA->getHash();
    }

    public function getFieldBearer() {
        return $this->_fieldBearer;
    }

    public function getErrors() {
        $selectedForm = $this->getSelectedForm();

        if (is_null($selectedForm)) {
            $errors = ["Please choose one of the following options."];
        } else {
            $errors = $selectedForm->getErrors();
        }

        return $errors;
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
        $this->getSelectedForm()->addError($error);
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