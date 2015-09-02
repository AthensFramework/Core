<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\FieldInterface;


class FieldBearerBuilder {

    /**
     * @var FieldBearerInterface[]
     */
    protected $_fieldBearers = [];

    /**
     * @var FieldInterface[]
     */
    protected $_fields = [];

    /**
     * @var string[]
     */
    protected $_visibleFieldNames;

    /**
     * @var string[]
     */
    protected $_hiddenFieldNames;

    /**
     * @var callable
     */
    protected $_saveFunction;

    /**
     * @param FieldBearerInterface[] $fieldBearers
     * @return FieldBearerBuilder
     */
    public function addFieldBearers($fieldBearers)
    {
        $this->_fieldBearers = array_merge($fieldBearers, $this->_fieldBearers);
        return $this;
    }

    /**
     * @param FieldInterface[] $fields
     * @return FieldBearerBuilder
     */
    public function addFields($fields) {
        $this->_fields = array_merge($fields, $this->_fields);
        return $this;
    }

    /**
     * @param \Propel\Runtime\ActiveRecord\ActiveRecordInterface $object
     * @return FieldBearerBuilder
     */
    public function addObject($object) {
        $this->addFieldBearers([new ClassFieldBearer($object)]);
        return $this;
    }

    /**
     * @param string $classTableMapName
     * @return FieldBearerBuilder
     */
    public function addClassTableMapName($classTableMapName) {
        $this->addFieldBearers([ClassFieldBearer::fromClassTableMapName($classTableMapName)]);
        return $this;
    }

    /**
     * @param \string[] $visibleFieldNames
     * @return FieldBearerBuilder
     */
    public function setVisibleFieldNames($visibleFieldNames)
    {
        $this->_visibleFieldNames = $visibleFieldNames;
        return $this;
    }

    /**
     * @param string[] $hiddenFieldNames
     * @return FieldBearerBuilder
     */
    public function setHiddenFieldNames($hiddenFieldNames)
    {
        $this->_hiddenFieldNames = $hiddenFieldNames;
        return $this;
    }

    /**
     * @param callable $saveFunction
     * @return FieldBearerBuilder
     */
    public function setSaveFunction($saveFunction)
    {
        $this->_saveFunction = $saveFunction;
        return $this;
    }


    /**
     * @return FieldBearerBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return FieldBearerBuilder
     */
    public function clear() {
        $this->_fieldBearers = [];
        $this->_fields = [];
        $this->_visibleFieldNames = null;
        $this->_hiddenFieldNames = null;
        $this->_saveFunction = null;

        return $this;
    }

    /**
     * @return FieldBearer
     * @throws \Exception if neither fields nor fieldBearers has been set
     */
    public function build() {
        if (!$this->_fields && !$this->_fieldBearers) {
            throw new \Exception("Must make fields and/or fieldBearers before calling this method.");
        }
        return new FieldBearer(
            $this->_fields,
            $this->_fieldBearers,
            $this->_visibleFieldNames,
            $this->_hiddenFieldNames,
            $this->_saveFunction
        );
    }

}