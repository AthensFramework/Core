<?php

namespace Athens\Core\Writable;

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
    
    /**
     * @return string
     */
    public function getType();

    /**
     * @param string $class
     * @return WritableInterface
     */
    public function addClass($class);

    /**
     * @param string $key
     * @param string $value
     * @return WritableInterface
     */
    public function addData($key, $value);

    /**
     * @param string $type
     * @return WritableInterface
     */
    public function setType($type);
}
