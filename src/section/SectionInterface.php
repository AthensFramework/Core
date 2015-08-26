<?php

namespace UWDOEM\Framework\Section;


use UWDOEM\Framework\Writer\WritableInterface;


interface SectionInterface extends WritableInterface {

    /**
     * @return null
     */
    public function init();

    /**
     * @return string
     */
    public function getLabel();

    /**
     * @return string
     */
    public function getContent();

    /**
     * @return SectionInterface[]
     */
    public function getWritables();

}