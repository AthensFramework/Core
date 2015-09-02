<?php

namespace UWDOEM\Framework\Page;

use UWDOEM\Framework\Writer\WritableInterface;
use UWDOEM\Framework\Initializer\InitializableInterface;


interface PageInterface extends WritableInterface, InitializableInterface {

    /**
     * @return string
     */
    public function getTitle();

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
     * @return string
     */
    public function getType();

    /**
     * @return string[]
     */
    public function getBreadCrumbs();

    /**
     * @return string[]
     */
    public function getReturnTo();

    /**
     * @return WritableInterface
     */
    public function getWritable();

}