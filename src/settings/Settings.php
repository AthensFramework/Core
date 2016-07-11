<?php

namespace Athens\Core\Settings;

use Exception;

/**
 * Class Settings is a static class for maintaining application-wide settings.
 * 
 * @package Athens\Core\Etc
 */
class Settings implements SettingsInterface
{
    /** @var array */
    protected static $settings = [
        "templateDirectories" => [],
        "projectJS" => [],
        "projectCSS" => [],
        "acronyms" => [],
        "defaultEmailerClass" => '\Athens\Core\Emailer\PhpEmailer',
        "defaultRendererClass" => '\Athens\Core\Renderer\HTMLRenderer',
        "defaultWriterClass" => '\Athens\Core\Writer\HTMLWriter',
        "defaultExcelWriterClass" => '\Athens\Core\Writer\ExcelWriter',
        "defaultPDFWriterClass" => '\Athens\Core\Writer\PDFWriter',
        "defaultExcelRendererClass" => '\Athens\Core\Renderer\ExcelRenderer',
        "defaultPDFRendererClass" => '\Athens\Core\Renderer\PDFRenderer',
        "defaultInitializerClass" => '\Athens\Core\Initializer\Initializer',
        "defaultExcelInitializerClass" => '\Athens\Core\Initializer\Initializer',
        "defaultPDFInitializerClass" => '\Athens\Core\Initializer\Initializer',
        "defaultPagination" => 12
    ];

    /** @var Settings|null */
    protected static $instance;

    /**
     * Disallow class instantiation.
     */
    protected function __construct()
    {
    }

    /**
     * @param string $name
     * @return array $arguments
     * @throws Exception if setting attribute not found.
     */
    protected function get($name, array $arguments)
    {
        return static::$settings[$name];
    }

    /**
     * @param string $name
     * @param array $arguments
     * @throws Exception if setting attribute not found
     */
    protected function set($name, array $arguments)
    {
        if (is_array(static::$settings[$name])) {
            throw new Exception(
                "Setting $name is an array. Try using ::add" . ucfirst($name) . " method instead."
            );
        }

        static::$settings[$name] = $arguments[0];
    }

    protected function add($name, array $arguments)
    {
        static::$settings[$name] = array_merge(static::$settings[$name], $arguments);
    }

    public function __call($methodName, array $arguments)
    {
        if (method_exists($this, $methodName)) {
            call_user_func($this->$methodName, $arguments);
        }

        /** @var string[] $allowedMethodPrefixes */
        $allowedMethodPrefixes = ['add', 'get', 'set'];

        /** @var string $methodPrefix */
        $methodPrefix = substr($methodName, 0, 3);
        /** @var string $settingAttributeName */
        $settingAttributeName = lcfirst(substr($methodName, 3));

        if (array_search($methodPrefix, $allowedMethodPrefixes) === false) {
            throw new Exception("Method $methodName not found.");
        }

        $settingAttributeExists = array_key_exists($settingAttributeName, static::$settings);

        if ($settingAttributeExists === false) {
            throw new Exception(
                "Setting $settingAttributeName not found among (" . implode(', ', array_keys(static::$settings)) . ")."
            );
        }

        return $this->$methodPrefix($settingAttributeName, $arguments);
    }

    public static function getInstance()
    {
        if (static::$instance === null) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}
