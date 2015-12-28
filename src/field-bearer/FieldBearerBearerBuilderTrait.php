<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\Field;

trait FieldBearerBearerBuilderTrait
{

    /** @var FieldBearerBuilder */
    private $fieldBearerBuilder;

    /** @var mixed[] */
    private $initialFieldValues = [];

    /** @var mixed[] */
    private $choices = [];

    private function createFieldBearerBuilderIfNull()
    {
        if (is_null($this->fieldBearerBuilder)) {
            $this->fieldBearerBuilder = FieldBearerBuilder::begin();
        }
    }


    /**
     * @return FieldBearerBuilder
     */
    private function getFieldBearerBuilder()
    {
        $this->createFieldBearerBuilderIfNull();

        return $this->fieldBearerBuilder;
    }

    /**
     * @return FieldBearer
     */
    protected function buildFieldBearer()
    {
        $fieldBearer = $this->getFieldBearerBuilder()->build();

        foreach ($this->initialFieldValues as $fieldName => $value) {
            $fieldBearer->getFieldByName($fieldName)->setInitial($value);
        }

        foreach ($this->choices as $fieldName => $choices) {
            $field = $fieldBearer->getFieldByName($fieldName);

            $field->setType(Field::FIELD_TYPE_CHOICE);
            $field->setChoices($choices);
        }

        return $fieldBearer;
    }

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return $this
     */
    public function addFieldBearers(array $fieldBearers)
    {
        $this->getFieldBearerBuilder()->addFieldBearers($fieldBearers);
        return $this;
    }

    /**
     * @param \UWDOEM\Framework\Field\FieldInterface[] $fields
     * @return $this
     */
    public function addFields(array $fields)
    {
        $this->getFieldBearerBuilder()->addFields($fields);
        return $this;
    }

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return $this
     */
    public function addObject($object)
    {
        $this->getFieldBearerBuilder()->addObject($object);
        return $this;
    }

    /**
     * @param string[] $visibleFieldNames
     * @return $this
     */
    public function setVisibleFieldNames(array $visibleFieldNames)
    {
        $this->getFieldBearerBuilder()->setVisibleFieldNames($visibleFieldNames);
        return $this;
    }

    /**
     * @param string[] $hiddenFieldNames
     * @return $this
     */
    public function setHiddenFieldNames(array $hiddenFieldNames)
    {
        $this->getFieldBearerBuilder()->setHiddenFieldNames($hiddenFieldNames);
        return $this;
    }

    /**
     * @param callable $saveFunction
     * @return $this
     */
    public function setSaveFunction(callable $saveFunction)
    {
        $this->getFieldBearerBuilder()->setSaveFunction($saveFunction);
        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed  $value
     * @return $this
     */
    public function setInitialFieldValue($fieldName, $value)
    {
        $this->initialFieldValues[$fieldName] = $value;

        return $this;
    }

    /**
     * @param string $fieldName
     * @param array  $choices
     * @return $this
     */
    public function setFieldChoices($fieldName, array $choices)
    {
        $this->choices[$fieldName] = $choices;

        return $this;
    }
}
