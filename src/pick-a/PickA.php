<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;


class PickA implements PickAInterface {

    /** @var string */
    protected $_id;

    protected $_manifest = [];
    /**
     * @var
     */

    use VisitableTrait;


    public function getId() {
        return $this->_id;
    }

    public function __construct($id, $manifest) {
        $this->_manifest = $manifest;
        $this->_id = $id;
    }

    public function getWritables() {
        $writables = [];
        foreach ($this->_manifest as $key => $manifestItem) {
            if ($manifestItem instanceof WritableInterface) {
                $writables[$key] = $manifestItem;
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