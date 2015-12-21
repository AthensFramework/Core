<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Field\FieldBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Form\FormTrait;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Row\RowInterface;

/**
 * Class TableForm provides a form composed of multiple rows.
 *
 * @package UWDOEM\Framework\Table
 */
class TableForm implements TableFormInterface
{

    /** @var callable */
    protected $rowMakingFunction;

    /** @var RowInterface */
    protected $prototypicalRow;

    /** @var RowInterface[] */
    protected $rows;

    /** @var RowInterface[] */
    protected $initialRows;

    use VisitableTrait;
    use FormTrait;


    /** @return RowInterface */
    public function getPrototypicalRow()
    {
        return $this->prototypicalRow;
    }

    /** @return string */
    public function getId()
    {
        return $this->id;
    }

    /** @return RowInterface[] */
    public function getRows()
    {
        return $this->rows;
    }

    public function getFilter()
    {
        return new DummyFilter();
    }

    public function getFieldBearer()
    {
        $row = $this->getPrototypicalRow();

        if (!$row) {
            $row = $this->getRows()[0];
        }

        return $row->getFieldBearer();
    }

    /** @return RowInterface */
    protected function makeRow()
    {
        $rowMakingFunction = $this->rowMakingFunction;
        return $rowMakingFunction();
    }

    protected function findRowPrefixes()
    {
        $firstPrototypicalSlug = current($this->getPrototypicalRow()->getFieldBearer()->getVisibleFields())->getSlug();

        $submittedSlugs = array_keys($_POST);

        $submittedFirstSlugMatches = array_filter(
            $submittedSlugs,
            function ($postSlug) use ($firstPrototypicalSlug) {
                return strpos($postSlug, $firstPrototypicalSlug) !== false;
            }
        );

        $rowPrefixes = array_map(
            function ($name) use ($firstPrototypicalSlug) {
                return str_replace($firstPrototypicalSlug, "", $name);
            },
            $submittedFirstSlugMatches
        );

        return $rowPrefixes;
    }

    protected function makeRows()
    {
        $rows = $this->initialRows;

        if ($this->getPrototypicalRow()) {
            foreach ($this->findRowPrefixes() as $prefix) {
                $newRow = $this->makeRow();

                foreach ($this->getPrototypicalRow()->getFieldBearer()->getFields() as $name => $field) {

                    $suffix = implode("-", $field->getSuffixes());

                    $newField = $newRow->getFieldBearer()->getFieldByName($name);

                    $newField->addSuffix($suffix);
                    $newField->addPrefix(trim($prefix, "-"));

                    $slug = $newField->getSlug();

                    if (isset($_POST[$slug])) {
                        $newField->setInitial($_POST[$slug]);
                    }
                }
                $rows[] = $newRow;
            }
        }
        return $rows;
    }

    protected function validate()
    {
        $this->isValid = true;

        $this->rows = $this->makeRows();

        // Validate each row indogenously
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getFields() as $name => $field) {
                $field->validate();
            }
        }

        // Validate each row exogenously
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getFields() as $name => $field) {
                if (array_key_exists($name, $this->validators)) {
                    foreach ($this->validators[$name] as $validator) {
                        call_user_func_array($validator, [$field, $this]);
                    }
                }
            }
        }

        // See if there exist any invalid fields
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getVisibleFields() as $name => $field) {
                if (!$field->isValid()) {
                    $this->isValid = false;
                    $this->addError("Please correct the indicated errors and resubmit the form.");
                    break;
                }
            }
        }
    }

    public function __construct(
        $id,
        $type,
        $method,
        $target,
        $rows,
        $rowMakingFunction,
        callable $onValidFunc,
        callable $onInvalidFunc,
        $actions = [],
        $validators = []
    ) {

        $this->id = $id;
        $this->type = $type;

        $this->method = $method;
        $this->target = $target;

        $this->actions = $actions;
        $this->rowMakingFunction = $rowMakingFunction;

        $this->prototypicalRow = is_callable($rowMakingFunction) ? $rowMakingFunction() : null;

        $this->onInvalidFunc = $onInvalidFunc;
        $this->onValidFunc = $onValidFunc;

        $this->validators = $validators;

        $this->subForms = [];

        $this->rows = $rows;
        $this->initialRows = $rows;
    }
}
