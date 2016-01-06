<?php

namespace UWDOEM\Framework\Section;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Field\FieldBuilder;
use UWDOEM\Framework\Writer\WritableInterface;

/**
 * Class SectionBuilder
 *
 * @package UWDOEM\Framework\Section
 */
class SectionBuilder extends AbstractBuilder
{

    /** @var string */
    protected $type;

    /** @var WritableInterface[] */
    protected $writables = [];

     /**
     * @param string $label
     * @return SectionBuilder
     */
    public function addLabel($label)
    {
        $label = FieldBuilder::begin()
            ->setType(Field::FIELD_TYPE_SECTION_LABEL)
            ->setLabel($label)
            ->setInitial($label)
            ->build();
        
        $this->addWritable($label);
        return $this;
    }

    /**
     * @param string $handle
     * @return SectionBuilder
     * @throws \Exception If type has not been set to ajax-loaded.
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
     * @throws \Exception If type is ajax-loaded.
     */
    public function addContent($content)
    {
        if ($this->type === "ajax-loaded") {
            throw new \Exception("Cannot set content on an ajax-loaded section.");
        }

        $content = FieldBuilder::begin()
            ->setType(Field::FIELD_TYPE_LITERAL)
            ->setLabel("section-content")
            ->setInitial($content)
            ->build();

        $this->addWritable($content);
        
        return $this;
    }

    /**
     * @param string $type
     * @return SectionBuilder
     * @throws \Exception If setting type to ajax-loaded and content has been set.
     */
    public function setType($type)
    {
        if ($type === "ajax-loaded" && $this->content !== null) {
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
     * @throws \Exception If type has not been set to 'ajax-loaded'.
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
    public function addWritable(WritableInterface $writable)
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

        if ($this->type === null) {
            $this->type = "base";
        }

        return new Section($this->id, $this->writables, $this->type);
    }
}
