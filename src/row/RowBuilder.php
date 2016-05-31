<?php

namespace Athens\Core\Row;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\FieldBearer\FieldBearerBearerBuilderTrait;

/**
 * Class RowBuilder
 * @package Athens\Core\Row
 */
class RowBuilder extends AbstractBuilder
{

    /** @var string */
    protected $onClick;

    /** @var boolean */
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
     * @throws \Exception If the developer tries to give a highlightable row an onClick.
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

        if ($this->highlightable === true && $this->onClick !== null) {
            throw new \Exception("You cannot both make a row highlightable and provide an onClick.");
        }

        if ($this->highlightable === true) {
            $this->onClick = "athens.highlightRow(this)";
        }

        return new Row(
            $this->classes,
            $this->data,
            $fieldBearer,
            $this->onClick,
            $this->highlightable
        );
    }
}
