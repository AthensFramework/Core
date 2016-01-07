<?php

namespace UWDOEM\Framework\FieldBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use UWDOEM\Framework\Field\Field;

trait FieldBearerBearerBuilderTrait
{

    /** @var FieldBearerBuilder */
    private $fieldBearerBuilder;

    /**
     * @return void
     */
    private function createFieldBearerBuilderIfNull()
    {
        if ($this->fieldBearerBuilder === null) {
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
     * @param ActiveRecordInterface $object
     * @return $this
     */
    public function addObject(ActiveRecordInterface $object)
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
        $this->getFieldBearerBuilder()->setInitialFieldValue($fieldName, $value);

        return $this;
    }

    /**
     * @param string $fieldName
     * @param mixed  $label
     * @return $this
     */
    public function setFieldLabel($fieldName, $label)
    {
        $this->getFieldBearerBuilder()->setFieldLabel($fieldName, $label);

        return $this;
    }

    /**
     * @param string $fieldName
     * @param array  $choices
     * @return $this
     */
    public function setFieldChoices($fieldName, array $choices)
    {
        $this->getFieldBearerBuilder()->setFieldChoices($fieldName, $choices);

        return $this;
    }

    /**
     * @return $this
     */
    public function makeLiteral()
    {
        $this->getFieldBearerBuilder()->makeLiteral();

        return $this;
    }
}
