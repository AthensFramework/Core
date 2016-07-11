<?php

namespace Athens\Core\Section;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableTrait;
use Athens\Core\WritableBearer\WritableBearerBearerTrait;
use Athens\Core\WritableBearer\WritableBearerInterface;

/**
 * A very general display element. May contain other writable elements.
 *
 * @package Athens\Core\Section
 */
class Section implements SectionInterface
{
    use VisitableTrait;
    use WritableTrait;
    use WritableBearerBearerTrait;

    /**
     * Create a new section
     *
     * @param string                  $id
     * @param string[]                $classes
     * @param array                   $data
     * @param WritableBearerInterface $writableBearer
     * @param string                  $type
     */
    public function __construct($id, array $classes, array $data, WritableBearerInterface $writableBearer, $type)
    {
        $this->id = $id;
        $this->classes = $classes;
        $this->type = $type;
        $this->data = $data;
        
        $this->writableBearer = $writableBearer;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return SectionInterface[]
     */
    public function getWritables()
    {
        return $this->writableBearer->getWritables();
    }
}
