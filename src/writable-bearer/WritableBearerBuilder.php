<?php

namespace Athens\Core\WritableBearer;

use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Writable\WritableInterface;

/**
 * Class WritableBearerBuilder
 *
 * @package Athens\Core\WritableBearer
 */
class WritableBearerBuilder extends AbstractWritableBuilder
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
     * @param string            $name
     * @return WritableBearerBuilder
     */
    public function addWritable(WritableInterface $writable, $name = null)
    {
        if ($name === null || $name === '') {
            $this->writables[] = $writable;
        } else {
            $this->writables[$name] = $writable;
        }

        return $this;
    }

    /**
     * @param WritableBearerInterface $writableBearer
     * @param string                  $name
     * @return $this
     */
    public function addWritableBearer(WritableBearerInterface $writableBearer, $name = '')
    {
        $this->addWritable($writableBearer, $name);

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeWritable($name)
    {
        $this->writables = array_diff_key($this->writables, [$name => '']);

        return $this;
    }

    /**
     * @param array $writableNames
     * @return $this
     */
    public function intersectWritableNames(array $writableNames)
    {
        $this->writables = array_intersect_key(
            $this->writables,
            array_flip($writableNames)
        );

        return $this;
    }

    /**
     * @param mixed $object
     * @return $this
     */
    public function addObject($object)
    {
        $object = $this->wrapObject($object);
        $fields = $object->getFields();

        foreach ($fields as $name => $field) {
            $this->addWritable($field, $name);
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
