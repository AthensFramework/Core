<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;

/**
 * A very general display element. May contain other writable elements.
 *
 * @package UWDOEM\Framework\Section
 */
class Section implements SectionInterface
{

    /** @var string */
    protected $_id;

    /** @var string */
    protected $_label;

    /** @var string */
    protected $_content;

    /** @var WritableInterface[] */
    protected $_writables;

    /** @var callable */
    protected $_initFromPost;

    /** @var callable */
    protected $_initFromGet;

    /** @var  string */
    protected $_type;
    /**
     * @var
     */
    private $id;

    use VisitableTrait;


    public function getId()
    {
        return $this->_id;
    }

    /**
     * Create a new section
     *
     * @param string $id
     * @param string $content
     * @param WritableInterface[] $writables
     * @param string $label
     * @param $type
     */
    public function __construct($id, $content, array $writables, $label, $type)
    {
        $this->_id = $id;
        $this->_label = $label;
        $this->_content = $content;
        $this->_writables = $writables;
        $this->_type = $type;
        $this->id = $id;
    }

    /**
     * Return the section's label.
     * @return string
     */
    public function getLabel()
    {
        return $this->_label;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->_content;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->_type;
    }

    /**
     * @return SectionInterface[]
     */
    public function getWritables()
    {
        return $this->_writables;
    }
}
