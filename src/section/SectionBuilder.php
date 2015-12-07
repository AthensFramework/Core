<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Writer\WritableInterface;


class SectionBuilder extends AbstractBuilder {

    /** @var string */
    protected $_label = "";

    /** @var string */
    protected $_content;

    /** @var string */
    protected $_type;

    /** @var WritableInterface[] */
    protected $_writables = [];


    /**
     * @param string $label
     * @return SectionBuilder
     */
    public function setLabel($label) {
        $this->_label = $label;
        return $this;
    }

    /**
     * @param string $handle
     * @return SectionBuilder
     * @throws \Exception if type has not been set to ajax-loaded
     */
    public function setHandle($handle) {

        if ($this->_type !== "ajax-loaded") {
            throw new \Exception("Handle may only be set on an ajax-loaded section. " .
                "Set type to 'ajax-loaded' before invoking this method.");
        }

        $this->_label = $handle;
        return $this;
    }

    /**
     * @param string $content
     * @return SectionBuilder
     * @throws \Exception if type is ajax-loaded
     */
    public function setContent($content) {
        if ($this->_type === "ajax-loaded") {
            throw new \Exception("Cannot set content on an ajax-loaded section.");
        }

        $this->_content = $content;
        return $this;
    }

    /**
     * @param string $type
     * @return SectionBuilder
     * @throws \Exception if setting type to ajax-loaded and content has been set
     */
    public function setType($type) {
        if ($type === "ajax-loaded" && isset($this->_content)) {
            throw new \Exception("Cannot set type to 'ajax-loaded' because content has already been set; " .
                "an ajax-loaded section must not have content.");
        }
        $this->_type = $type;
        return $this;
    }

    /**
     * @param string $target
     * @return SectionBuilder
     * @throws \Exception if type has not been set to 'ajax-loaded'
     */
    public function setTarget($target) {
        if ($this->_type !== "ajax-loaded") {
            throw new \Exception("Target may only be set on an ajax-loaded section. " .
            "Set type to 'ajax-loaded' before invoking this method.");
        }

        $this->_content = $target;

        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @return SectionBuilder
     */
    public function addWritable($writable) {
        $this->_writables[] = $writable;
        return $this;
    }

    /**
     * @return SectionInterface
     */
    public function build() {

        $this->validateId();

        if (!isset($this->_type)) {
            $this->_type = "base";
        }

        if (!isset($this->_content)) {
            $this->_content = "";
        }

        return new Section($this->_id, $this->_content, $this->_writables, $this->_label, $this->_type);
    }

}