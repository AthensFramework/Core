<?php

namespace Athens\Core\Form;

use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Field\Field;

/**
 * Class FormBuilder
 *
 * @package Athens\Core\Form
 */
class FormBuilder extends AbstractWritableBuilder
{
    use FormBuilderTrait;

    /**
     * @param string $label
     * @return FormBuilder
     */
    public function addLabel($label)
    {
        $labelField = FieldBuilder::begin()
            ->setType(FieldBuilder::TYPE_SECTION_LABEL)
            ->setLabel($label)
            ->build();

        return $this->addWritable($labelField, $label);
    }

    /**
     * @return Form
     * @throws \Exception If setFieldBearer has not been called.
     */
    public function build()
    {
        $this->validateId();

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateActions();

        $writableBearer = $this->buildWritableBearer();
        $this->modifyFields($writableBearer);

        return new Form(
            $this->id, $this->classes, $this->data, $this->type, $this->method, $this->target, $writableBearer, $this->onValidFunction, $this->onInvalidFunction, $this->actions, $this->validators, []
        );
    }
}
