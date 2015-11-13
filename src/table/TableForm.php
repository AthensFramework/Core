<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Form\FormTrait;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Row\RowBuilder;


class TableForm implements TableFormInterface {

    /** @var callable */
    protected $_rowMakingFunction;

    /** @var RowInterface */
    protected $_prototypicalRow;

    /** @var  RowInterface[] */
    protected $_rows;

    use VisitableTrait;
    use FormTrait;


    /** @return RowInterface */
    public function getPrototypicalRow() {
        return $this->_prototypicalRow;
    }

    public function getHash() {
        return $this->getPrototypicalRow()->getHash();
    }

    public function getRows() {
        return $this->_rows;
    }

    public function getFilter() {
        return new DummyFilter();
    }

    public function getFieldBearer() {
        return $this->getPrototypicalRow()->getFieldBearer();
    }

    /** @return RowInterface */
    protected function makeRow() {
        $rowMakingFunction = $this->_rowMakingFunction;
        return $rowMakingFunction();
    }

    protected function findRowPrefixes() {
        $firstPrototypicalSlug = current($this->getPrototypicalRow()->getFieldBearer()->getFields())->getSlug();

        $submittedSlugs = array_keys($_POST);

        $submittedFirstSlugMatches = array_filter($submittedSlugs, function($postSlug) use ($firstPrototypicalSlug) {
            return strpos($postSlug, $firstPrototypicalSlug) !== false;
        });

        $rowPrefixes = array_map(function($name) use ($firstPrototypicalSlug) {
            return str_replace($firstPrototypicalSlug, "", $name);
        }, $submittedFirstSlugMatches);

        return $rowPrefixes;
    }

    protected function makeRows() {
        $rows = [];
        foreach ($this->findRowPrefixes() as $prefix) {
            $newRow = $this->makeRow();

            foreach($this->getPrototypicalRow()->getFieldBearer()->getFields() as $name=>$field) {

                $suffix = implode("-",$field->getSuffixes());

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
        return $rows;
    }

    protected function validate() {
        $this->_isValid = true;

        $this->_rows = $this->makeRows();

        // Validate each row indogenously
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getFields() as $name => $field) {
                $field->validate();
            }
        }

        // Validate each row exogenously
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getFields() as $name => $field) {
                if (array_key_exists($name, $this->_validators)) {
                    foreach($this->_validators[$name] as $validator) {
                        call_user_func_array($validator, [$field, $this]);
                    }
                }
            }
        }

        // See if there exist any invalid fields
        foreach ($this->getRows() as $row) {
            foreach ($row->getFieldBearer()->getFields() as $name => $field) {
                if (!$field->isValid()) {
                    $this->_isValid = False;
                    $this->addError("Please correct the indicated errors and resubmit the form.");
                    break;
                }
            }
        }
    }

    public function __construct(
        callable $rowMakingFunction,
        callable $onValidFunc,
        callable $onInvalidFunc,
        $actions = [],
        $validators = []
    ) {
        $this->_actions = $actions;
        $this->_rowMakingFunction = $rowMakingFunction;

        $this->_prototypicalRow = $rowMakingFunction();

        $this->_onInvalidFunc = $onInvalidFunc;
        $this->_onValidFunc = $onValidFunc;

        $this->_validators = $validators;

        $this->_subForms = [];
    }

}