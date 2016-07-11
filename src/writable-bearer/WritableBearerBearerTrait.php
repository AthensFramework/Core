<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Writable\WritableInterface;

trait WritableBearerBearerTrait
{

    /** @var  WritableBearerInterface */
    protected $writableBearer;

    /**
     * @return WritableBearerInterface
     */
    public function getWritableBearer()
    {
        return $this->writableBearer;
    }

    /**
     * @return WritableInterface[]
     */
    public function getWritables()
    {
        return $this->writableBearer->getWritables();
    }
}
