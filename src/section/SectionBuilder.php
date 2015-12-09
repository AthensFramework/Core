<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Writer\WritableInterface;

class SectionBuilder extends AbstractBuilder
{

    /** @var string */
    protected $label = "";

    /** @var string */
    protected $content;

    /** @var string */
    protected $type;

    /** @var WritableInterface[] */
    protected $writables = [];


    /**
     * @param string $label
     * @return SectionBuilder
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @param string $handle
     * @return SectionBuilder
     * @throws \Exception if type has not been set to ajax-loaded
     */
    public function setHandle($handle)
    {

        if ($this->type !== "ajax-loaded") {
            throw new \Exception(
                "Handle may only be set on an ajax-loaded section. " .
                "Set type to 'ajax-loaded' before invoking this method."
            );
        }

        $this->label = $handle;
        return $this;
    }

    /**
     * @param string $content
     * @return SectionBuilder
     * @throws \Exception if type is ajax-loaded
     */
    public function setContent($content)
    {
        if ($this->type === "ajax-loaded") {
            throw new \Exception("Cannot set content on an ajax-loaded section.");
        }

        $this->content = $content;
        return $this;
    }

    /**
     * @param string $type
     * @return SectionBuilder
     * @throws \Exception if setting type to ajax-loaded and content has been set
     */
    public function setType($type)
    {
        if ($type === "ajax-loaded" && isset($this->content)) {
            throw new \Exception(
                "Cannot set type to 'ajax-loaded' because content has already been set; " .
                "an ajax-loaded section must not have content."
            );
        }
        $this->type = $type;
        return $this;
    }

    /**
     * @param string $target
     * @return SectionBuilder
     * @throws \Exception if type has not been set to 'ajax-loaded'
     */
    public function setTarget($target)
    {
        if ($this->type !== "ajax-loaded") {
            throw new \Exception(
                "Target may only be set on an ajax-loaded section. " .
                "Set type to 'ajax-loaded' before invoking this method."
            );
        }

        $this->content = $target;

        return $this;
    }

    /**
     * @param WritableInterface $writable
     * @return SectionBuilder
     */
    public function addWritable($writable)
    {
        $this->writables[] = $writable;
        return $this;
    }

    /**
     * @return SectionInterface
     */
    public function build()
    {

        $this->validateId();

        if (!isset($this->type)) {
            $this->type = "base";
        }

        if (!isset($this->content)) {
            $this->content = "";
        }

        return new Section($this->id, $this->content, $this->writables, $this->label, $this->type);
    }
}
