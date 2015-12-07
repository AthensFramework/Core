<?php

namespace UWDOEM\Framework\FieldBearer;

trait FieldBearerBearerBuilderTrait
{

    /** @var FieldBearerBuilder */
    private $_fieldBearerBuilder;

    /** @var mixed[] */
    private $_initialFieldValues = [];

    private function createFieldBearerBuilderIfNull()
    {
        if (is_null($this->_fieldBearerBuilder)) {
            $this->_fieldBearerBuilder = FieldBearerBuilder::begin();
        }
    }


    /**
     * @return FieldBearerBuilder
     */
    private function getFieldBearerBuilder()
    {
        $this->createFieldBearerBuilderIfNull();

        return $this->_fieldBearerBuilder;
    }

    /**
     * @return FieldBearer
     */
    protected function buildFieldBearer()
    {
        $fieldBearer = $this->getFieldBearerBuilder()->build();

        foreach ($this->_initialFieldValues as $fieldName => $value) {
            $fieldBearer->getFieldByName($fieldName)->setInitial($value);
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
     * @param mixed $value
     * @return $this
     */
    public function setInitialFieldValue($fieldName, $value)
    {
        $this->_initialFieldValues[$fieldName] = $value;

        return $this;
    }
}
