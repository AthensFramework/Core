<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Writer\Writer;
use UWDOEM\Framework\Page\PageInterface;

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
