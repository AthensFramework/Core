<?php
/**
 * Project documentation index page.
 */

require_once dirname(__FILE__) ."/../setup.php";

use UWDOEM\Framework\Section\SectionBuilder;
use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Page\Page;

$section = SectionBuilder::begin()
    ->setContent("")
    ->build();

$page = PageBuilder::begin()
    ->setTitle(APPLICATION_NAME . " - Project Documentation")
    ->setType(Page::PAGE_TYPE_MARKDOWN_DOCUMENTATION)
    ->setWritable($section)
    ->setBaseHref("..")
    ->build();

$page->render(null, null);