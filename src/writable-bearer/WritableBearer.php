<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Writable\WritableTrait;

/**
 * A very general display element. May contain other writable elements.
 * 
 * Generally renders to html as a <span> element.
 *
 * @package Athens\Core\WritableBearer
 */
class WritableBearer implements WritableBearerInterface
{

    /** @var WritableInterface[] */
    protected $writables;

    use VisitableTrait;
    use WritableTrait;
    
    public function __construct($id, array $classes, array $data, array $writables)
    {
        $this->id = $id;
        $this->classes = $classes;
        $this->data = $data;
        
        $this->writables = $writables;
    }

    /**
     * @return WritableInterface[]
     */
    public function getWritables()
    {
        return $this->writables;
    }
}
