<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Etc\AbstractBuilder;


class PickABuilder extends AbstractBuilder {

    protected $_manifest = [];

    /**
     * @return PickA
     */
    public function build() {
        $this->validateId();

        return new PickA($this->_id, $this->_manifest);
    }

    /**
     * @param string $label
     * @return PickABuilder
     */
    public function addLabel($label) {
        $this->_manifest[$label] = null;
        return $this;
    }

    /**
     * @param \UWDOEM\Framework\Writer\WritableInterface[] $writables
     * @return PickABuilder
     */
    public function addWritables(array $writables) {
        $this->_manifest = array_merge($this->_manifest, $writables);
        return $this;
    }

}