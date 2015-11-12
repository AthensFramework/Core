<?php

namespace UWDOEM\Framework\FieldBearer;


trait FieldBearerBearerBuilderTrait {

    /** @var FieldBearerBuilder */
    private $_fieldBearerBuilder;

    private function createFieldBearerBuilderIfNull() {
        if (is_null($this->_fieldBearerBuilder)) {
            $this->_fieldBearerBuilder = FieldBearerBuilder::begin();
        }
    }


    /**
     * @return FieldBearerBuilder
     */
    protected function getFieldBearerBuilder() {
        $this->createFieldBearerBuilderIfNull();

        return $this->_fieldBearerBuilder;
    }

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return $this
     */
    public function addFieldBearers(array $fieldBearers) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->addFieldBearers($fieldBearers);
        return $this;
    }

    /**
     * @param \UWDOEM\Framework\Field\FieldInterface[] $fields
     * @return $this
     */
    public function addFields(array $fields) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->addFields($fields);
        return $this;
    }

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return $this
     */
    public function addObject($object) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->addObject($object);
        return $this;
    }

    /**
     * @param string[] $visibleFieldNames
     * @return $this
     */
    public function setVisibleFieldNames(array $visibleFieldNames) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->setVisibleFieldNames($visibleFieldNames);
        return $this;
    }

    /**
     * @param string[] $hiddenFieldNames
     * @return $this
     */
    public function setHiddenFieldNames(array $hiddenFieldNames) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->setHiddenFieldNames($hiddenFieldNames);
        return $this;
    }

    /**
     * @param callable $saveFunction
     * @return $this
     */
    public function setSaveFunction(callable $saveFunction) {
        $this->createFieldBearerBuilderIfNull();

        $this->_fieldBearerBuilder->setSaveFunction($saveFunction);
        return $this;
    }

}