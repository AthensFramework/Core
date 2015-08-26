<?php

namespace UWDOEM\Framework\FieldBearer;

use UWDOEM\Framework\Field\FieldInterface;


class FieldBearerBuilder {

    /**
     * @var FieldBearerInterface[]
     */
    protected $_fieldBearers;

    /**
     * @var FieldInterface[]
     */
    protected $_fields;

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
    public function setFieldBearers($fieldBearers)
    {
        $this->_fieldBearers = $fieldBearers;
        return $this;
    }

    /**
     * @param FieldInterface[] $fields
     * @return FieldBearerBuilder
     */
    public function setFields($fields)
    {
        $this->_fields = $fields;
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
    
    public function clear() {
        $this->_fieldBearers = null;
        $this->_fields = null;
        $this->_visibleFieldNames = null;
        $this->_hiddenFieldNames = null;
        $this->_saveFunction = null;

        return $this;
    }

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