<?php

namespace Athens\Core\ORMWrapper;

/**
 * Class AbstractObjectWrapper
 *
 * @package Athens\Core\ORMWrapper
 */
abstract class AbstractObjectWrapper extends AbstractORMWrapper implements ObjectWrapperInterface
{
    /** @var array AbstractObjectWrapper[] */
    protected static $hashTable = [];

    /**
     * @param mixed $object
     * @return ObjectWrapperInterface
     */
    public static function fromObject($object)
    {
        $hash = spl_object_hash($object);

        if (
               array_key_exists($hash, static::$hashTable) === true
            && $object === static::$hashTable[$hash]->getObject()
        ) {
            return static::$hashTable[$hash];
        } else {
            $result = new static($object);
            static::$hashTable[$hash] = $result;

            return $result;
        }
    }

    /**
     * AbstractObjectWrapper constructor.
     * @param mixed $object
     */
    abstract protected function __construct($object);

    /**
     * @return mixed
     */
    abstract protected function getObject();
}
