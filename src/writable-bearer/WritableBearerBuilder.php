<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Etc\SafeString;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Writable\WritableInterface;

class WritableBearerBuilder extends AbstractBuilder
{

    /** @var string */
    protected $type = "base";

    /** @var WritableInterface[] */
    protected $writables = [];
    
    use WritableBearerBearerBuilderTrait;

    /**
     * @return WritableBearerBuilder
     */
    protected function getWritableBearerBuilder()
    {
        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @param string $name
     * @return WritableBearerBuilder
     */
    public function addWritable(WritableInterface $writable, $name = "") {
        if ($name === "") {
            $this->writables[] = $writable;
        } else {
            $this->writables[$name] = $writable;
        }

        return $this;
    }
    
    /**
     * @return WritableBearerInterface
     */
    public function build()
    {
        return new WritableBearer($this->id, $this->classes, $this->data, $this->writables, $this->type);
    }
}
