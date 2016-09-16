<?php

namespace Athens\Core\Choice;

use Athens\Core\Etc\StringUtils;
use Athens\Core\Visitor\VisitableTrait;

use DateTime;
use Athens\Core\Writable\WritableTrait;

/**
 * Class Choice implements ChoiceInterface
 *
 * @package Athens\Core\Choice
 */
class Choice implements ChoiceInterface
{

    use WritableTrait;
    use VisitableTrait;

    /** @var string */
    protected $alias;

    /** @var string */
    protected $value;
    
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
     * @param string $id
     * @param string[] $classes
     * @param string[] $data
     * @param string $value
     * @param string $alias
     */
    public function __construct(
        $id, array $classes, array $data, $value, $alias
    ) {
        $this->value = $value;
        $this->alias = $alias;

        $this->id = $id;
        $this->classes = $classes;
        $this->data = $data;
    }
}
