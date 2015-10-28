<?php

namespace UWDOEM\Framework\PickA;


class PickABuilder {

    protected $_manifest = [];

    public function build() {
        return new PickA($this->_manifest);
    }

    /**
     * @param string $label
     * @return PickABuilder
     */
    public function addLabel($label) {
        $this->_manifest[] = [$label => null];
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

    /**
     * @return PickABuilder
     */
    public static function begin() {
        return new static();
    }

}