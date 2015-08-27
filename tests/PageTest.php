<?php

use UWDOEM\Framework\Page\PageBuilder;

use UWDOEM\Framework\Section\SectionBuilder;


class PageTest extends PHPUnit_Framework_TestCase
{

    /**
     * @return PageBuilder[]
     */
    public function testedSectionBuilders() {
        // Return a fieldBearerBuilder of every type you want to test
        return [
            PageBuilder::begin(),
        ];
    }

    /**
     * Basic tests for the Section builder classes.
     *
     * Any test here could potentially fail because of a failure in the constructed section.
     *
     * @throws \Exception
     */
    public function testBuilder() {

        $content = "content";
        $label = "label";

        $writable = SectionBuilder::begin()
            ->setContent($content)
            ->setLabel($label)
            ->build();

        $breadCrumbs = ["name" => "http://link"];
        $returnTo = ["Another name" => "http://another.link"];
        $baseHref = ".";
        $header = "header";
        $subHeader = "subHeader";

        $page = PageBuilder::begin()
            ->setBaseHref($baseHref)
            ->setBreadCrumbs($breadCrumbs)
            ->setWritable($writable)
            ->setHeader($header)
            ->setSubHeader($subHeader)
            ->setReturnTo($returnTo)
            ->build();

        $this->assertEquals($writable, $page->getWritable());
        $this->assertEquals($baseHref, $page->getBaseHref());
        $this->assertEquals($breadCrumbs, $page->getBreadCrumbs());
        $this->assertEquals($header, $page->getHeader());
        $this->assertEquals($subHeader, $page->getSubHeader());
        $this->assertEquals($returnTo, $page->getReturnTo());
    }

    /*
     * The below methods are tested sufficiently above
    public function testGetWritables() {

    }

    public function testGetLabel() {

    }

    public function testGetContent() {

    }
    */


}

