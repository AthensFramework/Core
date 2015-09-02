<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Visitor\VisitableTrait;
use UWDOEM\Framework\Writer\WritableInterface;


/**
 * A very general display element. May contain other writable elements.
 *
 * @package UWDOEM\Framework\Section
 */
class Section implements SectionInterface {

    /**
     * The section's label.
     * @var string
     */
    protected $_label;

    /**
     * @var string
     */
    protected $_content;

    /**
     * @var WritableInterface[]
     */
    protected $_writables;

    /**
     * @var callable
     */
    protected $_initFromPost;

    /**
     * @var callable
     */
    protected $_initFromGet;

    use VisitableTrait;

    /**
     * Create a new section
     *
     * @param string $content
     * @param WritableInterface[] $writables
     * @param string $label
     */
    public function __construct($content, array $writables, $label) {
        $this->_label = $label;
        $this->_content = $content;
        $this->_writables = $writables;
    }

    /**
     * Return the section's label.
     * @return string
     */
    public function getLabel() {
        return $this->_label;
    }

    /**
     * @return string
     */
    public function getContent() {
        return $this->_content;
    }

    /**
     * @return SectionInterface[]
     */
    public function getWritables() {
        return $this->_writables;
    }




}