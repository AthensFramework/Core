<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Form\FormAction\FormAction;
use UWDOEM\Framework\Visitor\VisitableTrait;

class Form implements FormInterface
{

    use FormTrait;
    use VisitableTrait;

    /** @var string */
    protected $_id;

    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return null
     */
    protected function validate()
    {
        $this->_isValid = true;

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            $field->validate();
        }

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            if (array_key_exists($name, $this->_validators)) {
                foreach ($this->_validators[$name] as $validator) {
                    call_user_func_array($validator, [$field, $this]);
                }
            }
        }

        foreach ($this->getFieldBearer()->getVisibleFields() as $name => $field) {
            if (!$field->isValid()) {
                $this->_isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
                break;
            }
        }

        foreach ($this->getSubForms() as $subForm) {
            // Force validation on each subform via isValid()
            // If subform isn't valid and this form is not yet invalid, mark it as invalid
            if (!$subForm->isValid() && $this->_isValid) {
                $this->_isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
            }
        }

        if (!empty($this->_errors)) {
            $this->_isValid = false;
        }
    }

    /**
     * @param string $id
     * @param FieldBearerInterface $fieldBearer
     * @param callable $onValidFunc
     * @param callable $onInvalidFunc
     * @param array|null $actions
     * @param array $subForms
     * @param array[]|null $validators
     */
    public function __construct(
        $id,
        FieldBearerInterface $fieldBearer,
        callable $onValidFunc,
        callable $onInvalidFunc,
        $actions = [],
        $subForms = [],
        $validators = []
    ) {
        $this->_actions = $actions;
        $this->_fieldBearer = $fieldBearer;

        $this->_onInvalidFunc = $onInvalidFunc;
        $this->_onValidFunc = $onValidFunc;

        $this->_validators = $validators;
        $this->_subForms = $subForms;
        $this->_id = $id;
    }
}
