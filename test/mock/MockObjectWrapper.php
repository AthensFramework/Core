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
    
    public function __construct(MockObject $object)
    {
        $this->object = $object;

        $pascalCasedObjectName = str_replace(' ', '', ucwords($object->getTitleCasedName()));

        $this->keys = [];
        foreach ($object->getTitleCasedColumnNames() as $columnName) {
            $this->keys[] = "$pascalCasedObjectName." . str_replace(' ', '', ucwords($columnName));
        }
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
            $this->object->getTitleCasedColumnNames()
        );
    }
    
    public function getTitleCasedObjectName()
    {
        return $this->object->getTitleCasedName();
    }

    public function getPk()
    {
        return $this->object->pk;
    }
    
    public function fillFromFields(array $fields)
    {
        return $this->object->fillFromFields($fields);
    }

    public function __toString()
    {
        return array_values($this->object->getValues())[0];
    }
}
