<?php
/**
 * Project documentation index page.
 */

require_once dirname(__FILE__) ."/../setup.php";

use Athens\Core\Page\PageBuilder;
use Athens\Core\Page\Page;


$page = PageBuilder::begin()
    ->setId('documentation-browser')
    ->setTitle(APPLICATION_NAME . " - Project Documentation")
    ->setType(Page::PAGE_TYPE_MARKDOWN_DOCUMENTATION)
    ->setBaseHref("..")
    ->build();

$page->render(null, null);
