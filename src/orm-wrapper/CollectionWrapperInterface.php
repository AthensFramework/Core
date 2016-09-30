<?php

namespace Athens\Core\ORMWrapper;

use ArrayAccess;
use IteratorAggregate;
use Countable;

interface CollectionWrapperInterface extends ArrayAccess, IteratorAggregate, Countable
{

}