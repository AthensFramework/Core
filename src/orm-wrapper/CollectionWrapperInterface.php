<?php

namespace Athens\Core\ORMWrapper;

use ArrayAccess;
use Iterator;
use Countable;

interface CollectionWrapperInterface extends ArrayAccess, Iterator, Countable
{

    /**
     * Save all elements of the collection.
     *
     * @return void
     */
    public function save();

    /**
     * Delete all elements of the collection.
     *
     * @return void
     */
    public function delete();
}
