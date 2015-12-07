<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Writer\WritableInterface;

interface PickAInterface extends WritableInterface
{

    /**
     * @return array
     */
    public function getManifest();

    /**
     * @return string[]
     */
    public function getLabels();

    /**
     * @return WritableInterface[]
     */
    public function getWritables();
}
