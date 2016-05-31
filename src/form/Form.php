<?php

namespace Athens\Core\Form;

use Athens\Core\FieldBearer\FieldBearerInterface;
use Athens\Core\Visitor\VisitableTrait;

/**
 * Class Form contains fields and tests them for submission-validity.
 *
 * @package Athens\Core\Form
 */
class Form implements FormInterface
{

    use FormTrait;
    use VisitableTrait;

    /**
     * Determine whether the form is valid.
     *
     * Updates $this->isValid and $this->errors according to whether the form is
     * valid and whether it has errors.
     *
     * @return void
     */
    protected function validate()
    {
        $this->isValid = true;

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            $field->validate();
        }

        foreach ($this->getFieldBearer()->getFields() as $name => $field) {
            if (array_key_exists($name, $this->validators) === true) {
                foreach ($this->validators[$name] as $validator) {
                    call_user_func_array($validator, [$field, $this]);
                }
            }
        }

        foreach ($this->getFieldBearer()->getVisibleFields() as $name => $field) {
            if ($field->isValid() === false) {
                $this->isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
                break;
            }
        }

        foreach ($this->getSubForms() as $subForm) {
            // Force validation on each subform via isValid()
            // If subform isn't valid and this form is not yet invalid, mark it as invalid
            if ($subForm->isValid() === false && $this->isValid === true) {
                $this->isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
            }
        }

        if ($this->errors !== []) {
            $this->isValid = false;
        }
    }

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param array                $data
     * @param string               $type
     * @param string               $method
     * @param string               $target
     * @param FieldBearerInterface $fieldBearer
     * @param callable             $onValidFunc
     * @param callable             $onInvalidFunc
     * @param array|null           $actions
     * @param array|null           $subForms
     * @param array[]|null         $validators
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        $type,
        $method,
        $target,
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
        $this->type = $type;
        $this->method = $method;
        $this->target = $target;
        $this->classes = $classes;
        $this->data = $data;
    }
}
