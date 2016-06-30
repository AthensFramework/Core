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
    protected $alias;

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
        return md5($this->getValue() . $this->getAlias());
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getAlias()
    {
        return $this->alias;
    }

    /**
     * @param string[] $classes
     * @param string[] $data
     * @param string   $value
     * @param string   $alias
     */
    public function __construct(
        array $classes,
        array $data,
        $value,
        $alias
    ) {
        $this->value = $value;
        $this->alias = $alias;

        $this->classes = $classes;
        $this->data = $data;
    }
}
