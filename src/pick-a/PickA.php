<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Writer\WritableTrait;

/**
 * Class PickA presents users with multiple sections which may be viewed
 * only one at a time.
 *
 * @package UWDOEM\Framework\PickA
 */
class PickA implements PickAInterface
{

    /** @var array */
    protected $manifest = [];

    use VisitableTrait;
    use WritableTrait;

    /**
     * @param string   $id
     * @param string[] $classes
     * @param array    $manifest
     */
    public function __construct($id, array $classes, array $manifest)
    {
        $this->manifest = $manifest;
        $this->id = $id;
        $this->classes = $classes;
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
