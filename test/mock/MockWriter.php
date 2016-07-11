<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Writer\HTMLWriter;
use Athens\Core\Page\PageInterface;

class MockHTMLWriter extends HTMLWriter
{

    public static $used = false;

    public function visitPage(PageInterface $page)
    {
        static::$used = true;

        parent::visitPage($page);
    }

    public function getEnvironment()
    {
        return parent::getEnvironment();
    }
}
