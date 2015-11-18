<?php

namespace UWDOEM\Framework\Row;


use UWDOEM\Framework\FieldBearer\FieldBearerBearerBuilderTrait;


class RowBuilder {

    /**
     * @var string
     */
    protected $_onClick;

    /**
     * @var bool
     */
    protected $_highlightable = false;

    use FieldBearerBearerBuilderTrait;


    /**
     * @param string $onClick
     * @return RowBuilder
     */
    public function setOnClick($onClick) {
        $this->_onClick = $onClick;
        return $this;
    }

    /**
     * @param boolean $highlightable
     * @return RowBuilder
     */
    public function setHighlightable($highlightable) {
        $this->_highlightable = $highlightable;
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

        $fieldBearer = $this->buildFieldBearer();

        if (sizeof($fieldBearer->getFields()) === 0) {
            throw new \RuntimeException("You must specify an implementation of FieldBearerInterface using ::setFieldBearer before calling this method.");
        }

        return new Row(
            $fieldBearer,
            $this->_onClick,
            $this->_highlightable);
    }



}