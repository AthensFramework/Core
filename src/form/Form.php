<?php

namespace UWDOEM\Framework\Form;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;

class Form implements FormInterface
{

    use FormTrait;
    use VisitableTrait;


    /**
     * @return null
     */
    protected function validate()
    {
        $this->isValid = true;

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            $field->validate();
        }

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            if (array_key_exists($name, $this->validators)) {
                foreach ($this->validators[$name] as $validator) {
                    call_user_func_array($validator, [$field, $this]);
                }
            }
        }

        foreach ($this->getFieldBearer()->getVisibleFields() as $name => $field) {
            if (!$field->isValid()) {
                $this->isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
                break;
            }
        }

        foreach ($this->getSubForms() as $subForm) {
            // Force validation on each subform via isValid()
            // If subform isn't valid and this form is not yet invalid, mark it as invalid
            if (!$subForm->isValid() && $this->isValid) {
                $this->isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
            }
        }

        if (!empty($this->errors)) {
            $this->isValid = false;
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
        $this->actions = $actions;
        $this->fieldBearer = $fieldBearer;

        $this->onInvalidFunc = $onInvalidFunc;
        $this->onValidFunc = $onValidFunc;

        $this->validators = $validators;
        $this->subForms = $subForms;
        $this->id = $id;
    }
}
