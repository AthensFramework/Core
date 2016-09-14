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

    /**
     * WritableBearer constructor.
     * @param string $id
     * @param array  $classes
     * @param array  $data
     * @param array  $writables
     */
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

    /**
     * @param string $handle
     * @return WritableInterface|null
     */
    public function getWritableByHandle($handle)
    {
        return array_key_exists($handle, $this->writables) === true ? $this->writables[$handle] : null;
    }
}
