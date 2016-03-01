<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Writer\Writer;
use Athens\Core\Page\PageInterface;

class MockWriter extends Writer
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
