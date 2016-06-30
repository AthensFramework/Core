<?php

namespace Athens\Core\Choice;

use Athens\Core\Etc\StringUtils;
use Athens\Core\Visitor\VisitableTrait;

use DateTime;
use Athens\Core\Writer\WritableTrait;

/**
 * Class Choice implements ChoiceInterface
 *
 * @package Athens\Core\Choice
 */
class Choice implements ChoiceInterface
{

    use WritableTrait;

    /** @var string */
    protected $key;

    /** @var string */
    protected $value;
    
    use VisitableTrait;

    /**
     * Provides the unique identifier for this choice.
     *
     * @return string
     */
    public function getId()
    {
        return md5($this->getKey() . $this->getValue());
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param string[] $classes
     * @param string[] $data
     * @param string   $key
     * @param string   $value
     */
    public function __construct(
        array $classes,
        array $data,
        $key,
        $value
    ) {
        $this->key = $key;
        $this->value = $value;

        $this->classes = $classes;
        $this->data = $data;
    }
}
