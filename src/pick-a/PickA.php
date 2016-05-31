<?php

namespace Athens\Core\PickA;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writer\WritableInterface;
use Athens\Core\Writer\WritableTrait;

/**
 * Class PickA presents users with multiple sections which may be viewed
 * only one at a time.
 *
 * @package Athens\Core\PickA
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
     * @param string[] $data
     * @param array    $manifest
     */
    public function __construct($id, array $classes, array $data, array $manifest)
    {
        $this->manifest = $manifest;
        $this->id = $id;
        $this->classes = $classes;
        $this->data = $data;
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
