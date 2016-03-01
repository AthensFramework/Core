<?php

namespace Athens\Core\Table;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Row\RowInterface;
use Athens\Core\Form\FormBuilderTrait;

/**
 * Class TableFormBuilder
 *
 * @package Athens\Core\Table
 */
class TableFormBuilder extends AbstractBuilder
{

    use FormBuilderTrait;

    /** @var callable */
    protected $rowMakingFunction;

    /** @var RowInterface[] */
    protected $rows = [];

    /** @var boolean */
    protected $canRemove = true;

    /**
     * @param RowInterface[] $rows
     * @return TableFormBuilder
     */
    public function setRows(array $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @param callable $rowMakingFunction
     * @return TableFormBuilder
     */
    public function setRowMakingFunction(callable $rowMakingFunction)
    {
        $this->rowMakingFunction = $rowMakingFunction;
        return $this;
    }

    /**
     * @return void
     */
    protected function validateOnInvalidFunc()
    {
        if ($this->onInvalidFunc === null) {

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

    /**
     * @return void
     */
    protected function validateOnValidFunc()
    {
        if ($this->onValidFunc === null) {
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
     * @param boolean $canRemove
     * @return TableFormBuilder
     */
    public function setCanRemove($canRemove)
    {
        $this->canRemove = $canRemove;
        return $this;
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
            $this->classes,
            $this->type,
            $this->method,
            $this->target,
            $this->rows,
            $this->rowMakingFunction,
            $this->onValidFunc,
            $this->onInvalidFunc,
            $this->canRemove,
            $this->actions,
            $this->validators
        );
    }
}
