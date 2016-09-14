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
     * @param string $class
     * @return $this
     */
    public function addClass($class)
    {
        $this->classes[] = $class;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function addData($key, $value)
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }
}
