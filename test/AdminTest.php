<?php

namespace Athens\Core\Test;

use Exception;

use Athens\Core\Admin\AdminBuilder;
use Athens\Core\Admin\Admin;
use Athens\Core\Field\FieldInterface;
use Athens\Core\Form\FormInterface;
use Athens\Core\Table\TableInterface;

use Athens\Core\Test\Mock\MockObjectWrapper;

class AdminTest extends TestCase
{

    public function setUp()
    {
        $this->createORMFixtures();
    }

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
        $baseHref = ".";
        $header = "header";
        $subHeader = "subHeader";

        $admin = AdminBuilder::begin()
            ->setId($id)
            ->setTitle($title)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setBaseHref($baseHref)
            ->addBreadCrumb(array_keys($breadCrumbs)[0], array_values($breadCrumbs)[0])
            ->setHeader($header)
            ->setSubHeader($subHeader)
            ->addQuery($this->query)
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

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();
    }

    /**
     *
     */
    public function testPageMode()
    {
        $_GET['mode'] = Admin::MODE_PAGE;

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();

        $this->assertEquals('page-content', $admin->getWritables()[0]->getId());
    }

    public function testTableMode()
    {
        $this->collection->method('valid')->will(
            $this->onConsecutiveCalls(true, true, false)
        );

        $this->collection->method('current')->will(
            $this->onConsecutiveCalls(
                new MockObjectWrapper($this->instances[0]),
                new MockObjectWrapper($this->instances[1])
            )
        );

        $_GET['mode'] = Admin::MODE_TABLE;
        $_SERVER['REQUEST_URI'] = '.';

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();

        $writables = $admin->getWritables();
        
        $this->assertInstanceOf(TableInterface::class, $writables[0]->getWritables()[0]->getWritables()[1]);
        
        $table = $writables[0]->getWritables()[0]->getWritables()[1];
        
        $this->assertEquals(sizeof($this->instances) + 1, sizeof($table->getRows()));
    }

    public function testDetailMode()
    {
        $_GET['mode'] = Admin::MODE_DETAIL;

        $_GET[Admin::OBJECT_ID_FIELD] = 0;
        $_GET[Admin::QUERY_INDEX_FIELD] = 0;

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();

        $writables = $admin->getWritables();

        $this->assertInstanceOf(FieldInterface::class, $writables[0]);
        $this->assertInstanceOf(FormInterface::class, $writables[1]);

        $this->instances[0]->expects($this->once())->method('save');

        $writables[1]->onValid();
    }

    public function testDetailModeWithoutId()
    {
        $_GET['mode'] = Admin::MODE_DETAIL;

        unset($_GET[Admin::OBJECT_ID_FIELD]);
        $_GET[Admin::QUERY_INDEX_FIELD] = 0;

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();

        $writables = $admin->getWritables();

        $this->assertInstanceOf(FieldInterface::class, $writables[0]);
        $this->assertInstanceOf(FormInterface::class, $writables[1]);
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #Object not found.*#
     */
    public function testDetailModeWithNonExistentObject()
    {
        $_GET['mode'] = Admin::MODE_DETAIL;

        $_GET[Admin::OBJECT_ID_FIELD] = 2;
        $_GET[Admin::QUERY_INDEX_FIELD] = 0;

        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();

        $writables = $admin->getWritables();

        $this->assertInstanceOf(FieldInterface::class, $writables[0]);
        $this->assertInstanceOf(FormInterface::class, $writables[1]);

        $this->instances[0]->expects($this->once())->method('save');

        $writables[1]->onValid();
    }

    public function testDeleteMode()
    {
        $_GET['mode'] = Admin::MODE_DELETE;

        $_GET[Admin::OBJECT_ID_FIELD] = 0;
        $_GET[Admin::QUERY_INDEX_FIELD] = 0;

        $this->instances[0]->expects($this->once())->method('delete');
        
        $admin = AdminBuilder::begin()
            ->setId("test-page")
            ->addQuery($this->query)
            ->build();
    }
}
