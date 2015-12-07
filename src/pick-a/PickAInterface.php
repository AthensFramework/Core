<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Writer\WritableInterface;

interface PickAInterface extends WritableInterface
{

    /**
     * @return array
     */
    function getManifest();

    /**
     * @return string[]
     */
    function getLabels();

    /**
     * @return WritableInterface[]
     */
    function getWritables();
}
