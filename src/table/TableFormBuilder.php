<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\Form\FormBuilderTrait;

class TableFormBuilder extends AbstractBuilder
{

    use FormBuilderTrait;

    /** @var callable */
    protected $rowMakingFunction;


    /**
     * @param callable $rowMakingFunction
     * @return TableFormBuilder
     */
    public function setRowMakingFunction(callable $rowMakingFunction)
    {
        $this->rowMakingFunction = $rowMakingFunction;
        return $this;
    }

    protected function validateOnInvalidFunc()
    {
        if (!isset($this->onInvalidFunc)) {

            $this->onInvalidFunc = function (TableFormInterface $form) {
                foreach ($form->getRows() as $row) {
                    foreach ($row->getFieldBearer()->getFields() as $field) {
                        if ($field->getType() !== Field::FIELD_TYPE_LITERAL) {
                            $field->setInitial($field->getSubmitted());
                        }
                    }
                }
            };

        }
    }

    protected function validateOnValidFunc()
    {
        if (!isset($this->onValidFunc)) {
            $this->onValidFunc = function (TableFormInterface $form) {
                foreach ($form->getRows() as $row) {
                    $fieldBearer = $row->getFieldBearer();

                    $args = array_merge([$fieldBearer], func_get_args());
                    $func = [$fieldBearer, "save"];

                    call_user_func_array($func, $args);
                }
            };
        }
    }

    /**
     * @return TableForm
     */
    public function build()
    {

        $this->validateId();

        $this->validateOnInvalidFunc();
        $this->validateOnValidFunc();
        $this->validateOnSuccessUrl();
        $this->validateActions();

        return new TableForm(
            $this->id,
            $this->type,
            $this->rowMakingFunction,
            $this->onValidFunc,
            $this->onInvalidFunc,
            $this->actions,
            $this->validators
        );
    }
}
