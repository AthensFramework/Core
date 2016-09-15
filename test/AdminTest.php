<?php

namespace Athens\Core\Test;

use Athens\Core\Initializer\Initializer;
use Athens\Core\Renderer\HTMLRenderer;
use Exception;

use PHPUnit_Framework_TestCase;

use Athens\Core\Page\Page;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Settings\Settings;
use Athens\Core\Admin\AdminBuilder;
use Athens\Core\Admin\Admin;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Table\TableInterface;
use Athens\Core\Row\RowInterface;

use Athens\Core\Test\Mock\MockQuery;
use Athens\Core\Test\Mock\MockHTMLWriter;
use Athens\Core\Test\Mock\MockInitializer;

use AthensTest\TestClass;
use AthensTest\TestClassQuery;
use AthensTest\Map\TestClassTableMap;

class AdminTest extends PHPUnit_Framework_TestCase
{

    /**
     * Basic tests for the Section builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed section.
     *
     * @throws \Exception
     */
    public function testBuilder()
    {

        $id = "i" . (string)rand();
        $title = "title";
        $classes = [(string)rand(), (string)rand()];
        $breadCrumbs = ["name" => "http://link"];
        $returnTo = ["Another name" => "http://another.link"];
        $baseHref = ".";
        $header = "header";
        $subHeader = "subHeader";

        $query = $this->createMock(TestClassQuery::class);

        $admin = AdminBuilder::begin()
            ->setId($id)
            ->setTitle($title)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setBaseHref($baseHref)
            ->addBreadCrumb(array_keys($breadCrumbs)[0], array_values($breadCrumbs)[0])
            ->setHeader($header)
            ->setSubHeader($subHeader)
            ->addQuery($query)
            ->build();

        $this->assertEquals($id, $admin->getId());
        $this->assertEquals($classes, $admin->getClasses());
        $this->assertEquals($title, $admin->getTitle());
        $this->assertEquals($baseHref, $admin->getBaseHref());
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #For an object manager page, you must provide a Propel query.*#
     */
    public function testBuildObjectManagerPageWithoutQuery()
    {
        
        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->build();
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Invalid object manager mode.*#
     */
    public function testInvalidMode()
    {
        $_GET['mode'] = 'asdflkjweoriu';

        $query = $this->createMock(TestClassQuery::class);

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($query)
            ->build();
    }

    /**
     *
     */
    public function testPageMode()
    {
        $_GET['mode'] = Admin::MODE_PAGE;

        $query = $this->createMock(TestClassQuery::class);

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($query)
            ->build();

        $this->assertEquals('page-content', $admin->getWritables()[0]->getId());
    }

    public function testTableMode()
    {
        $_GET['mode'] = Admin::MODE_TABLE;
        $_SERVER['REQUEST_URI'] = '.';

        $tableMap = $this->createMock(TestClassTableMap::class);
        $tableMap->method('getName')->willReturn('Test Class');

        $instances = [
            0 => $this->createMock(TestClass::class),
            1 => $this->createMock(TestClass::class),
        ];

        $query = $this->createMock(TestClassQuery::class);
        $query->method('getTableMap')->willReturn($tableMap);
        $query->method('find')->willReturn($instances);

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($query)
            ->build();

        $writables = $admin->getWritables();
        
        $this->assertInstanceOf(TableInterface::class, $writables[0]->getWritables()[0]->getWritables()[1]);
        
        $table = $writables[0]->getWritables()[0]->getWritables()[1];
        
        $this->assertEquals(sizeof($instances) + 1, sizeof($table->getRows()));

    }

    public function testDetailMode()
    {
        $_GET['mode'] = Admin::MODE_DETAIL;

        $instances = [
            0 => $this->createMock(TestClass::class),
            1 => $this->createMock(TestClass::class),
        ];

        $query = $this->createMock(TestClassQuery::class);

        $query->method('find')->willReturn($instances);
        $query->method('findOneById')->willReturn($instances[0]);

        $_GET[Admin::OBJECT_ID_FIELD] = 0;
        $_GET[Admin::QUERY_INDEX_FIELD] = 0;

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($query)
            ->build();

        $writables = $admin->getWritables();

        $this->assertInstanceOf(FieldInterface::class, $writables[0]);
        $this->assertInstanceOf(FormInterface::class, $writables[1]);
    }

    public function testDeleteMode()
    {
        $_GET['mode'] = Admin::MODE_DELETE;






    }
}
