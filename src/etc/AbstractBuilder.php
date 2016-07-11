<?php

namespace Athens\Core\Etc;

use Athens\Core\Settings\SettingsInterface;
use Athens\Core\Settings\Settings;

/**
 * Class AbstractBuilder is a parent class for all Builder classes.
 *
 * @package Athens\Core\Etc
 */
abstract class AbstractBuilder
{
    /** @var SettingsInterface */
    private $settingsInstance;

    /** @return static Return a new builder */
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
     * Return the element under construction.
     *
     * Returns an instance of the object type under construction.
     * @return mixed
     */
    abstract public function build();
}
