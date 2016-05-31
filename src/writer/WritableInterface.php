<?php

namespace Athens\Core\Writer;

use Athens\Core\Visitor\VisitableInterface;

interface WritableInterface extends VisitableInterface
{

    /**
     * Return a unique identifier that will be consistent between requests.
     *
     * @return string
     */
    public function getId();

    /**
     * @return string[]
     */
    public function getClasses();

    /**
     * @return string[]
     */
    public function getData();
}
