<?php

namespace Athens\Core\Link;

use Athens\Core\Writable\AbstractWritableBuilder;

/**
 * Class LinkBuilder
 * @package Athens\Core\Link
 */
class LinkBuilder extends AbstractWritableBuilder
{
    /** @var string */
    protected $uri;

    /** @var string */
    protected $text;

    /**
     * @param string $uri
     * @return LinkBuilder
     */
    public function setURI($uri)
    {
        $this->uri = $uri;
        return $this;
    }

    /**
     * @param string $text
     * @return LinkBuilder
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return Link
     * @throws \Exception If the correct settings have not been provided.
     */
    public function build()
    {
        if ($this->uri === null) {
            throw new \Exception("Must use ::setURI to set link URI before building");
        }

        if ($this->text === null) {
            throw new \Exception("Must use ::setText to set link text before building");
        }

        return new Link(
            $this->classes,
            $this->data,
            $this->type,
            $this->uri,
            $this->text
        );
    }
}
