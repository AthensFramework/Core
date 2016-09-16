<?php

namespace Athens\Core\Form;

use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\Field\FieldInterface;
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

        foreach ($this->getWritableBearer()->getWritables() as $name => $writable) {
            if ($writable instanceof FieldInterface) {
                $writable->validate();
            }
        }

        foreach ($this->getWritableBearer()->getWritables() as $name => $writable) {
            if (array_key_exists($name, $this->validators) === true) {
                foreach ($this->validators[$name] as $validator) {
                    call_user_func_array($validator, [$writable, $this]);
                }
            }
        }

        foreach ($this->getWritableBearer()->getWritables() as $name => $writable) {
            if ($writable instanceof FieldInterface && $writable->isValid() === false) {
                $this->isValid = false;
                $this->addError("Please correct the indicated errors and resubmit the form.");
                break;
            }
        }

        foreach ($this->getWritableBearer()->getWritables() as $writable) {
            // Force validation on each subform via isValid()
            // If subform isn't valid and this form is not yet invalid, mark it as invalid
            if ($writable instanceof FormInterface) {
                if ($writable->isValid() === false && $this->isValid === true) {
                    $this->isValid = false;
                    $this->addError("Please correct the indicated errors and resubmit the form.");
                }
            }
        }

        if ($this->errors !== []) {
            $this->isValid = false;
        }
    }

    /**
     * @param string $id
     * @param string[] $classes
     * @param array $data
     * @param string $type
     * @param string $method
     * @param string $target
     * @param WritableBearerInterface $fieldBearer
     * @param callable $onValidFunc
     * @param callable $onInvalidFunc
     * @param array|null $actions
     * @param array[]|null $validators
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        $type,
        $method,
        $target,
        WritableBearerInterface $fieldBearer,
        callable $onValidFunc,
        callable $onInvalidFunc,
        $actions = [],
        $validators = []
    ) {
    
        $this->actions = $actions;
        $this->writableBearer = $fieldBearer;

        $this->onInvalidFunc = $onInvalidFunc;
        $this->onValidFunc = $onValidFunc;

        $this->validators = $validators;
        $this->id = $id;
        $this->type = $type;
        $this->method = $method;
        $this->target = $target;
        $this->classes = $classes;
        $this->data = $data;
    }
}
