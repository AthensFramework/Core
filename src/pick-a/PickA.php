<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;

/**
 * Class PickA
 *
 * @package UWDOEM\Framework\PickA
 */
class PickA implements PickAInterface
{

    /** @var string */
    protected $id;

    /** @var array */
    protected $manifest = [];

    use VisitableTrait;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @param array  $manifest
     */
    public function __construct($id, array $manifest)
    {
        $this->manifest = $manifest;
        $this->id = $id;
    }

    /**
     * @return WritableInterface[]
     */
    public function getWritables()
    {
        $writables = [];
        foreach ($this->manifest as $key => $manifestItem) {
            if ($manifestItem instanceof WritableInterface) {
                $writables[$key] = $manifestItem;
            }
        }

        return $writables;
    }

    /**
     * @return string[]
     */
    public function getLabels()
    {
        $labels = [];
        foreach ($this->manifest as $key => $manifestItem) {
            if (($manifestItem instanceof WritableInterface) === false) {
                $labels[] = $key;
            }
        }

        return $labels;
    }

    /**
     * @return array
     */
    public function getManifest()
    {
        return $this->manifest;
    }
}
