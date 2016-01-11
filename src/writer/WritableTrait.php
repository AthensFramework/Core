<?php

namespace UWDOEM\Framework\Writer;

trait WritableTrait
{
    /** @var string */
    protected $id;

    /** @var string[] */
    protected $classes = [];

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string[]
     */
    public function getClasses()
    {
        return $this->classes;
    }
}
