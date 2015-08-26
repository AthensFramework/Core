<?php

namespace UWDOEM\Framework\Row;


use UWDOEM\Framework\FieldBearer\FieldBearerInterface;


class RowBuilder {

    /**
     * @var string
     */
    protected $_onClick;

    /**
     * @var FieldBearerInterface
     */
    protected $_fieldBearer;

    /**
     * @param string $onClick
     * @return RowBuilder
     */
    public function setOnClick($onClick) {
        $this->_onClick = $onClick;
        return $this;
    }

    /**
     * @param FieldBearerInterface $fieldBearer
     * @return RowBuilder
     */
    public function setFieldBearer(FieldBearerInterface $fieldBearer) {
        $this->_fieldBearer = $fieldBearer;
        return $this;
    }

    /**
     * @return RowBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return Row
     */
    public function build() {
        if (!isset($this->_fieldBearer)) {
            throw new \RuntimeException("You must specify an implementation of FieldBearerInterface using ::setFieldBearer before calling this method.");
        }
        return new Row($this->_fieldBearer, $this->_onClick);
    }



}