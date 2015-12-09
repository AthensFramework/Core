<?php

namespace UWDOEM\Framework\Row;

use UWDOEM\Framework\FieldBearer\FieldBearerInterface;
use UWDOEM\Framework\Visitor\VisitableTrait;

/**
 * A Table child which contains fields
 *
 * @package UWDOEM\Framework\Table\Row
 */
class Row implements RowInterface
{

    /**
     * A string containing the javascript action to take when this row is clicked.
     *
     * @var string
     */
    protected $onClick;

    /**
     * @var FieldBearerInterface
     */
    protected $fieldBearer;

    /**
     * @var bool
     */
    protected $highlightable;

    use VisitableTrait;


    public function getId()
    {
        return md5(
            json_encode(
                $this->getFieldBearer()->getFieldNames()
            )
        );
    }

    public function __construct(FieldBearerInterface $fieldBearer, $onClick, $highlightable)
    {
        $this->fieldBearer = $fieldBearer;
        $this->onClick = $onClick;
        $this->highlightable = $highlightable;
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
