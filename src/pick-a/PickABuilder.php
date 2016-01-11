<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Etc\AbstractBuilder;

/**
 * Class PickABuilder
 *
 * @package UWDOEM\Framework\PickA
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
     * @param \UWDOEM\Framework\Writer\WritableInterface[] $writables
     * @return PickABuilder
     */
    public function addWritables(array $writables)
    {
        $this->manifest = array_merge($this->manifest, $writables);
        return $this;
    }
}
