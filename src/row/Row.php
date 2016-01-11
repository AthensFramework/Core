<?php

namespace UWDOEM\Framework\Row;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableTrait;

/**
 * A Table child which contains fields
 *
 * @package UWDOEM\Framework\Table\Row
 */
class Row implements RowInterface
{

    /** @var string */
    protected $onClick;

    /** @var FieldBearerInterface */
    protected $fieldBearer;

    /** @var boolean */
    protected $highlightable;

    use VisitableTrait;
    use WritableTrait;

    /**
     * @param string[]             $classes
     * @param FieldBearerInterface $fieldBearer
     * @param string               $onClick
     * @param boolean              $highlightable
     */
    public function __construct(array $classes, FieldBearerInterface $fieldBearer, $onClick, $highlightable)
    {
        $this->fieldBearer = $fieldBearer;
        $this->onClick = $onClick;
        $this->highlightable = $highlightable;
        $this->classes = $classes;
    }

    /**
     * @return string
     */
    public function getOnClick()
    {
        return $this->onClick;
    }

    /**
     * @return FieldBearerInterface
     */
    public function getFieldBearer()
    {
        return $this->fieldBearer;
    }

    /**
     * @return boolean
     */
    public function isHighlightable()
    {
        return $this->highlightable;
    }
}
