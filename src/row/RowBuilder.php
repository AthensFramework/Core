<?php

namespace UWDOEM\Framework\Row;

use UWDOEM\Framework\FieldBearer\FieldBearerBearerBuilderTrait;

class RowBuilder
{

    /**
     * @var string
     */
    protected $onClick;

    /**
     * @var bool
     */
    protected $highlightable = false;

    use FieldBearerBearerBuilderTrait;


    /**
     * @param string $onClick
     * @return RowBuilder
     */
    public function setOnClick($onClick)
    {
        $this->onClick = $onClick;
        return $this;
    }

    /**
     * @param boolean $highlightable
     * @return RowBuilder
     */
    public function setHighlightable($highlightable)
    {
        $this->highlightable = $highlightable;
        return $this;
    }

    /**
     * @return RowBuilder
     */
    public static function begin()
    {
        return new static();
    }

    /**
     * @return Row
     */
    public function build()
    {

        $fieldBearer = $this->buildFieldBearer();

        if (sizeof($fieldBearer->getFields()) === 0) {
            throw new \RuntimeException(
                "You must specify an implementation of " .
                "FieldBearerInterface using ::setFieldBearer before calling this method."
            );
        }

        if ($this->highlightable && $this->onClick) {
            throw new \Exception("You cannot both make a row highlightable and provide an onClick.");
        }

        if ($this->highlightable) {
            $this->onClick = "uwdoem.highlightRow(this)";
        }

        return new Row(
            $fieldBearer,
            $this->onClick,
            $this->highlightable
        );
    }
}
