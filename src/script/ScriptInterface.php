<?php

namespace Athens\Core\Script;

use Athens\Core\Writable\WritableInterface;

interface ScriptInterface extends WritableInterface
{

    /**
     * @return string
     */
    public function getType();

    /**
     * @return string
     */
    public function getContents();
}
