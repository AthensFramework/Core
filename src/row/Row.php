<?php

namespace Athens\Core\Row;

use Athens\Core\WritableBearer\WritableBearerBearerTrait;
use Athens\Core\WritableBearer\WritableBearerInterface;
use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableTrait;

/**
 * A Table child which contains fields
 *
 * @package Athens\Core\Table\Row
 */
class Row implements RowInterface
{

    /** @var string */
    protected $onClick;

    /** @var boolean */
    protected $highlightable;

    /** @var string[] */
    protected $labels;

    use VisitableTrait;
    use WritableTrait;
    use WritableBearerBearerTrait;

    /**
     * @param string[] $classes
     * @param string[] $data
     * @param WritableBearerInterface $writableBearer
     * @param string[] $labels
     * @param string $onClick
     * @param boolean $highlightable
     */
    public function __construct(
        array $classes,
        array $data,
        WritableBearerInterface $writableBearer,
        array $labels,
        $onClick,
        $highlightable
    ) {
        $this->writableBearer = $writableBearer;
        $this->labels = $labels;
        $this->onClick = $onClick;
        $this->highlightable = $highlightable;
        $this->classes = $classes;
        $this->data = $data;
        $this->labels = $labels;
    }

    /**
     * @return string
     */
    public function getOnClick()
    {
        return $this->onClick;
    }

    /**
     * @return string[]
     */
    public function getLabels()
    {
        return $this->labels;
    }

    /**
     * @return boolean
     */
    public function isHighlightable()
    {
        return $this->highlightable;
    }
}
