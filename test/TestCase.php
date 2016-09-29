<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\Test\Mock\MockObject;
use Athens\Core\Test\Mock\MockQuery;

class TestCase extends PHPUnit_Framework_TestCase
{
    /** @var MockObject[] */
    protected $instances;
    protected $query;
    
    protected function createORMFixtures()
    {
        $this->instances = [
            0 => $this->createMock(MockObject::class),
            1 => $this->createMock(MockObject::class),
        ];

        foreach ($this->instances as $key => $instance) {
            $instance->method('getTitleCasedName')->willReturn('My Object');
            $instance->method('getUnqualifiedTitleCasedColumnNames')
                ->willReturn(
                    [
                        'Id', 'My Object Id', 'Value'
                    ]
                );
            $instance->method('getQualifiedPascalCasedColumnNames')
                ->willReturn(
                    [
                        'MyObject.Id', 'MyObject.MyObjectId', 'MyObject.Value'
                    ]
                );
            $instance->method('getValues')->willReturn([$key, $key + 1, "Object #$key"]);
            $instance->method('fillFromFields')->willReturn($instance);
            $instance->method('save')->willReturn($instance);
            $instance->method('getPrimaryKey')->willReturn($key);
        }

        $instanceMap = [
            [0, $this->instances[0]],
            [1, $this->instances[1]],
            [2, null],
        ];

        $this->query = $this->createMock(MockQuery::class);

        $this->query->method('orderBy')->willReturn($this->query);
        $this->query->method('filterBy')->willReturn($this->query);
        $this->query->method('offset')->willReturn($this->query);
        $this->query->method('limit')->willReturn($this->query);
        $this->query->method('find')->willReturn($this->instances);
        $this->query->method('findOneByPk')->willReturnMap($instanceMap);
        $this->query->method('getTitleCasedObjectName')->willReturn('My Object');
        $this->query->method('getPascalCasedObjectName')->willReturn('MyObject');
        $this->query->method('getQualifiedPascalCasedColumnNames')
            ->willReturn(
                [
                    'MyObject.Id' => 'MyObject.Id',
                    'MyObject.MyObjectId' => 'MyObject.MyObjectId',
                    'MyObject.Value' => 'MyObject.Value',
                ]
            );
        $this->query->method('getUnqualifiedTitleCasedColumnNames')
            ->willReturn(
                [
                    'MyObject.Id' => 'Id',
                    'MyObject.MyObjectId' => 'My Object Id',
                    'MyObject.Value' => 'Value',
                ]
            );
    }
}
