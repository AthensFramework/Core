<?php

namespace Athens\Core\Test\Mock;

use Athens\Core\ORMWrapper\AbstractCollectionWrapper;

class MockCollectionWrapper extends AbstractCollectionWrapper
{
    public function next()
    {
        die("HEREYO!");
    }
    
    public function count()
    {
    }
    
    public function offsetGet($offset)
    {
    }
    
    public function offsetSet($offset, $value)
    {
    }
    
    public function offsetUnset($offset)
    {
    }
    
    public function offsetExists($offset)
    {
    }

    public function save()
    {
    }
    
    public function delete()
    {
    }
    
    public function valid()
    {
    }
    
    public function current()
    {
    }
    
    public function rewind()
    {
    }
    
    public function key()
    {
    }
}
