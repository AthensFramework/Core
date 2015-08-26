<?php

namespace UWDOEM\Framework\Section;


use UWDOEM\Framework\Writer\WritableInterface;


class SectionBuilder {

    /**
     * The section's label. Set by overriding Section::makeLabel()
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
     * @param string $label
     * @return SectionBuilder
     */
    public function setLabel($label) {
        $this->_label = $label;
        return $this;
    }

    /**
     * @param string $content
     * @return SectionBuilder
     */
    public function setContent($content) {
        $this->_content = $content;
        return $this;
    }

    /**
     * @param WritableInterface[] $writables
     * @return SectionBuilder
     */
    public function setWritables($writables)
    {
        $this->_writables = $writables;
        return $this;
    }

    /**
     * @return SectionBuilder
     */
    public static function begin() {
        return new static();
    }

    /**
     * @return SectionInterface
     */
    public function build() {
        return new Section($this->_content, $this->_writables, $this->_label);
    }

}