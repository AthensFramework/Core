<?php

namespace Athens\Core\Writer;

trait WritableTrait
{
    /** @var string */
    protected $id;

    /** @var string[] */
    protected $classes = [];

    /** @var string[] */
    protected $data = [];

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

    /**
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }
}
