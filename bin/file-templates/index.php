<?php
/**
 * Project documentation index page.
 */

require_once dirname(__FILE__) ."/../setup.php";

use UWDOEM\Framework\Page\PageBuilder;
use UWDOEM\Framework\Page\Page;


$page = PageBuilder::begin()
    ->setTitle(APPLICATION_NAME . " - Project Documentation")
    ->setType(Page::PAGE_TYPE_MARKDOWN_DOCUMENTATION)
    ->setBaseHref("..")
    ->build();

$page->render(null, null);