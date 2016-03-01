<?php

namespace Athens\Core\PickA;

use Athens\Core\Etc\AbstractBuilder;

/**
 * Class PickABuilder
 *
 * @package Athens\Core\PickA
 */
class PickABuilder extends AbstractBuilder
{

    /** @var array */
    protected $manifest = [];

    /**
     * @return PickA
     */
    public function build()
    {
        $this->validateId();

        return new PickA($this->id, $this->classes, $this->manifest);
    }

    /**
     * @param string $label
     * @return PickABuilder
     */
    public function addLabel($label)
    {
        $this->manifest[$label] = null;
        return $this;
    }

    /**
     * @param \Athens\Core\Writer\WritableInterface[] $writables
     * @return PickABuilder
     */
    public function addWritables(array $writables)
    {
        $this->manifest = array_merge($this->manifest, $writables);
        return $this;
    }
}
