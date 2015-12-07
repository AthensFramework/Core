<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;

class PickA implements PickAInterface
{

    /** @var string */
    protected $id;

    protected $manifest = [];

    use VisitableTrait;


    public function getId()
    {
        return $this->id;
    }

    public function __construct($id, $manifest)
    {
        $this->manifest = $manifest;
        $this->id = $id;
    }

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

    public function getLabels()
    {
        $labels = [];
        foreach ($this->manifest as $key => $manifestItem) {
            if (!($manifestItem instanceof WritableInterface)) {
                $labels[] = $key;
            }
        }

        return $labels;
    }

    public function getManifest()
    {
        return $this->manifest;
    }
}
