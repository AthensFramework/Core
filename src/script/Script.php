<?php

namespace Athens\Core\Script;

use Athens\Core\Visitor\VisitableTrait;
use Athens\Core\Writable\WritableTrait;

/**
 * A very general display element. May contain other writable elements.
 *
 * @package Athens\Core\Script
 */
class Script implements ScriptInterface
{
    use WritableTrait;
    use VisitableTrait;
    
    /** @var string $contents */
    protected $contents;

    /**
     * Create a new script
     *
     * @param string   $id
     * @param string[] $classes
     * @param array    $data
     * @param string   $type
     * @param string   $contents
     */
    public function __construct($id, array $classes, array $data, $type, $contents)
    {
        $this->id = $id;
        $this->classes = $classes;
        $this->data = $data;
        $this->type = $type;
        
        $this->contents = $contents;
    }

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }
}
