<?php

namespace Athens\Core\Choice;

use Athens\Core\Etc\AbstractBuilder;
use Athens\Core\Etc\StringUtils;

/**
 * Class ChoiceBuilder
 *
 * @package Athens\Core\Choice
 */
class ChoiceBuilder extends AbstractBuilder
{

    /** @var string */
    protected $key;

    /** @var string */
    protected $value;

    /**
     * @param string $key
     * @return ChoiceBuilder
     */
    public function setKey($key)
    {
        $this->key = $key;
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

        if ($this->key === null) {
            $this->key = StringUtils::slugify($this->value);
        }

        return new Choice(
            $this->classes,
            $this->data,
            $this->key,
            $this->value
        );
    }
}
