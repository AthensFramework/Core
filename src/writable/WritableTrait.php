<?php

namespace Athens\Core\Writable;

trait WritableTrait
{
    /** @var string */
    protected $id;

    /** @var string[] */
    protected $classes = [];

    /** @var string[] */
    protected $data = [];

    /** @var string */
    protected $type = "base";

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

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}
