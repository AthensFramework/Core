<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\Page\PageInterface;
use Athens\Core\Initializer\Initializer;

class MockInitializer extends Initializer
{
    public static $used = false;

    public function visitPage(PageInterface $page)
    {
        static::$used = true;
    }
}
