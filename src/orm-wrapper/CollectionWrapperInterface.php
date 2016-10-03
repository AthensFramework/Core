<?php

namespace Athens\Core\ORMWrapper;

use ArrayAccess;
use Iterator;
use Countable;

interface CollectionWrapperInterface extends ArrayAccess, Iterator, Countable
{
    public function save();

    public function delete();
}