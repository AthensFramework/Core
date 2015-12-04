<?php

namespace UWDOEM\Framework\Writer;


use UWDOEM\Framework\Visitor\VisitableInterface;


interface WritableInterface extends VisitableInterface {

    /**
     * Return a unique identifier that will be consistent between requests.
     *
     * @return string
     */
    public function getId();

}