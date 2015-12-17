<?php

namespace UWDOEM\Framework\Test\Mock;

use UWDOEM\Framework\Page\PageInterface;
use UWDOEM\Framework\Initializer\Initializer;

class MockInitializer extends Initializer
{
    public static $used = false;

    public function visitPage(PageInterface $page)
    {
        static::$used = true;
    }
}
