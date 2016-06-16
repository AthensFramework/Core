<?php

namespace Athens\Core\Test;

use Exception;

use PHPUnit_Framework_TestCase;

use Athens\Core\Page\Page;
use Athens\Core\Section\SectionBuilder;
use Athens\Core\Etc\Settings;
use Athens\Core\Admin\AdminBuilder;

use Athens\Core\Test\Mock\MockQuery;
use Athens\Core\Test\Mock\MockWriter;
use Athens\Core\Test\Mock\MockInitializer;

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

        $query = new MockQuery();

        $query->find = [];

        $page = AdminBuilder::begin()
            ->setId($id)
            ->setTitle($title)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setBaseHref($baseHref)
            ->setBreadCrumbs($breadCrumbs)
            ->setHeader($header)
            ->setSubHeader($subHeader)
            ->setReturnTo($returnTo)
            ->addQuery($query)
//            ->setType($type)
            ->build();

        $this->assertEquals($id, $page->getId());
        $this->assertEquals($classes, $page->getClasses());
        $this->assertEquals($title, $page->getTitle());
        $this->assertEquals($baseHref, $page->getBaseHref());
        $this->assertEquals($breadCrumbs, $page->getBreadCrumbs());
        $this->assertEquals($header, $page->getHeader());
        $this->assertEquals($subHeader, $page->getSubHeader());
        $this->assertEquals($returnTo, $page->getReturnTo());
//        $this->assertEquals($type, $page->getType());
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
}
