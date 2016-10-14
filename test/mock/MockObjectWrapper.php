<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Field\FieldBuilder;
use Athens\Core\ORMWrapper\ObjectWrapperInterface;
use Athens\Core\ORMWrapper\AbstractObjectWrapper;

class MockObjectWrapper extends AbstractObjectWrapper implements ObjectWrapperInterface
{
    /** @var MockObject */
    protected $object;

    /** @var string[] */
    protected $keys;
    
    protected function __construct($object)
    {
        $this->object = $object;

        $pascalCasedObjectName = str_replace(' ', '', ucwords($object->getTitleCasedObjectName()));

        $this->keys = [];
        foreach ($object->getUnqualifiedTitleCasedColumnNames() as $columnName) {
            $this->keys[] = "$pascalCasedObjectName." . str_replace(' ', '', ucwords($columnName));
        }
    }

    public static function fromObject($object)
    {
        return new static($object);
    }

    public function getObject()
    {
    }

    public function save()
    {
    }
    
    public function delete()
    {
    }
    
    public function getValues()
    {
        return array_combine(
            $this->keys,
            $this->object->getValues()
        );
    }
    
    public function getFields()
    {
        $fields = [];
        foreach ($this->object->getValues() as $key => $value) {
            $fields[] = FieldBuilder::begin()
                ->setType(FieldBuilder::TYPE_TEXT)
                ->setLabel($key)
                ->setInitial((string)$value)
                ->build();
        }

        return array_combine(
            $this->keys,
            $fields
        );
    }
    
    public function getUnqualifiedTitleCasedColumnNames()
    {
        return array_combine(
            $this->keys,
            $this->object->getUnqualifiedTitleCasedColumnNames()
        );
    }
    
    public function getTitleCasedObjectName()
    {
        return $this->object->getTitleCasedObjectName();
    }

    public function getPrimaryKey()
    {
        return $this->object->getPrimaryKey();
    }
    
    public function fillFromFields(array $fields)
    {
        return $this->object->fillFromFields($fields);
    }

    public function __toString()
    {
        return array_values($this->object->getValues())[2];
    }
}
