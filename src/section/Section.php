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

    use VisitableTrait;


    public function getId() {
        return md5(
            $this->getLabel() . $this->getContent()
        );
    }

    /**
     * Create a new section
     *
     * @param string $content
     * @param WritableInterface[] $writables
     * @param string $label
     */
    public function __construct($content, array $writables, $label, $type) {
        $this->_label = $label;
        $this->_content = $content;
        $this->_writables = $writables;
        $this->_type = $type;
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
     * @return string
     */
    public function getType() {
        return $this->_type;
    }

    /**
     * @return SectionInterface[]
     */
    public function getWritables() {
        return $this->_writables;
    }




}