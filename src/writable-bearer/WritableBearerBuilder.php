<?php

namespace Athens\Core\WritableBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use Athens\Core\Etc\SafeString;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Field\Field;
use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Etc\ORMUtils;

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

    public function addWritableBearer(WritableBearerInterface $writableBearer, $name = '')
    {
        $this->addWritable($writableBearer, $name);

        return $this;
    }

    public function removeWritable($name)
    {
        $this->writables = array_diff_key($this->writables, [$name => '']);
        
        return $this;
    }

    public function addObject(ActiveRecordInterface $object)
    {
        $fields = ORMUtils::makeFieldsFromObject($object);

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
