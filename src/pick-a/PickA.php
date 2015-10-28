<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;


class PickA implements PickAInterface {

    protected $_manifest = [];

    use VisitableTrait;

    public function __construct($manifest) {
        $this->_manifest = $manifest;
    }

    public function getWritables() {
        $writables = [];
        foreach ($this->_manifest as $manifestItem) {
            if ($manifestItem instanceof WritableInterface) {
                $writables[] = $manifestItem;
            }
        }

        return $writables;
    }

    public function getLabels() {
        $labels = [];
        foreach ($this->_manifest as $key => $manifestItem) {
            if (!($manifestItem instanceof WritableInterface)) {
                $labels[] = $key;
            }
        }

        return $labels;
    }

    public function getManifest() {
        return $this->_manifest;
    }
}