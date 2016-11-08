<?php

namespace Athens\Core\Etc;

use Athens\Core\Settings\SettingsInterface;
use Athens\Core\Settings\Settings;
use Athens\Core\ORMWrapper\ObjectWrapperInterface;
use Athens\Core\ORMWrapper\QueryWrapperInterface;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package Athens\Core\Etc
 */
abstract class AbstractBuilder
{
    /** @var SettingsInterface */
    private $settingsInstance;

    /** @return $this Return a new builder */
    public static function begin()
    {
        return new static();
    }

    /** @return $this Return a new builder */
    public function clear()
    {
        return new static();
    }

    /**
     * @param SettingsInterface $settingsInstance
     * @return $this
     */
    protected function setSettingsInstance(SettingsInterface $settingsInstance)
    {
        $this->settingsInstance = $settingsInstance;

        return $this;
    }

    /**
     * @return SettingsInterface;
     */
    protected function getSettingsInstance()
    {
        return $this->settingsInstance === null ? Settings::getInstance() : $this->getSettingsInstance();
    }

    /**
     * @param mixed $object
     * @return ObjectWrapperInterface
     */
    public function wrapObject($object)
    {
        $objectWrapperClass = $this->getSettingsInstance()->getDefaultObjectWrapperClass();

        if (($object instanceof $objectWrapperClass) === false) {
            $object = $objectWrapperClass::fromObject($object);
        }

        return $object;
    }

    /**
     * @param mixed $query
     * @return QueryWrapperInterface
     */
    public function wrapQuery($query)
    {
        $queryWrapperClass = $this->getSettingsInstance()->getDefaultQueryWrapperClass();

        if (($query instanceof $queryWrapperClass) === false) {
            $query = new $queryWrapperClass($query);
        }

        return $query;
    }

    /**
     * Return the element under construction.
     *
     * Returns an instance of the object type under construction.
     * @return mixed
     */
    abstract public function build();
}
