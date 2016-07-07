<?php

namespace Athens\Core\Choice;

use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Etc\StringUtils;

/**
 * Class ChoiceBuilder
 *
 * @package Athens\Core\Choice
 */
class ChoiceBuilder extends AbstractWritableBuilder
{

    /** @var string */
    protected $alias;

    /** @var string */
    protected $value;

    /**
     * @param string $alias
     * @return ChoiceBuilder
     */
    public function setAlias($alias)
    {
        $this->alias = $alias;
        return $this;
    }

    /**
     * @param string $value
     * @return ChoiceBuilder
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
    

    /**
     * @return ChoiceInterface
     * @throws \Exception If the correct settings have not been provided.
     */
    public function build()
    {
        if ($this->value === null) {
            throw new \Exception("Must use ::setValue to set a value before building");
        }

        if ($this->alias === null) {
            $this->alias = (string)$this->value;
        }

        return new Choice(
            $this->classes,
            $this->data,
            $this->value,
            $this->alias
        );
    }
}
