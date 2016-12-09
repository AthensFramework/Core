<?php

namespace Athens\Core\Script;

use Athens\Core\Writable\AbstractWritableBuilder;

/**
 * Class ScriptBuilder
 *
 * @package Athens\Core\Script
 */
class ScriptBuilder extends AbstractWritableBuilder
{
    /** @var string */
    protected $contents = '';
    

    /**
     * @param string $contents
     * @return ScriptBuilder
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
        return $this;
    }

    /**
     * @return ScriptInterface
     */
    public function build()
    {
        return new Script($this->id, $this->classes, $this->data, $this->type, $this->contents);
    }
}
