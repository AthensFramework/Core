<?php

namespace UWDOEM\Framework\Page;

use UWDOEM\Framework\Section\SectionInterface;


interface PageInterface {

    /**
     * @return string
     */
    public function getBaseHref();

    /**
     * @return string
     */
    public function getHeader();

    /**
     * @return string
     */
    public function getSubHeader();

    /**
     * @return string[]
     */
    public function getBreadCrumbs();

    /**
     * @return string[]
     */
    public function getReturnTo();

    /**
     * @return SectionInterface
     */
    public function getWritable();

}