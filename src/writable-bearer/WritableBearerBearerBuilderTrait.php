<?php

namespace Athens\Core\WritableBearer;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use Athens\Core\Writable\WritableInterface;
use Athens\Core\Field\FieldBuilder;
use Athens\Core\Etc\SafeString;
use Athens\Core\Section\SectionBuilder;

trait WritableBearerBearerBuilderTrait
{
    /** @var WritableBearerBuilder */
    protected $writableBearerBuilder;

    /**
     * @return void
     */
    private function createWritableBearerBuilderIfNull()
    {
        if ($this->writableBearerBuilder === null) {
            $this->writableBearerBuilder = WritableBearerBuilder::begin();
        }
    }

    /**
     * @return WritableBearerBuilder
     */
    private function getWritableBearerBuilder()
    {
        $this->createWritableBearerBuilderIfNull();

        return $this->writableBearerBuilder;
    }

    /**
     * @return WritableBearerInterface
     */
    protected function buildWritableBearer()
    {
        $fieldBearer = $this->getWritableBearerBuilder()->build();

        return $fieldBearer;
    }
    
    /**
     * @param WritableInterface $writable
     * @param string            $handle
     * @return $this
     */
    public function addWritable(WritableInterface $writable, $handle = null)
    {
        $this->getWritableBearerBuilder()->addWritable($writable, $handle);
        
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeWritable($name)
    {
        $this->getWritableBearerBuilder()->removeWritable($name);

        return $this;
    }

    /**
     * @param ActiveRecordInterface $object
     * @return $this
     */
    public function addObject(ActiveRecordInterface $object)
    {
        $this->getWritableBearerBuilder()->addObject($object);
        return $this;
    }

    /**
     * @param string $label
     * @return WritableBearerBuilder
     */
    public function addLabel($label)
    {
        $label = FieldBuilder::begin()
            ->setType(FieldBuilder::TYPE_SECTION_LABEL)
            ->setLabel($label)
            ->setInitial($label)
            ->build();

        $this->addWritable($label);
        return $this;
    }

    /**
     * @param string $content
     * @return WritableBearerBuilder
     */
    public function addContent($content)
    {
        if (($content instanceof SafeString) === false) {
            $content = htmlentities($content);
        }
        $content = SafeString::fromString(nl2br($content));

        return $this->addLiteralContent($content);
    }

    /**
     * @param string $content
     * @return WritableBearerBuilder
     */
    public function addLiteralContent($content)
    {
        $content = FieldBuilder::begin()
            ->setType(FieldBuilder::TYPE_LITERAL)
            ->setLabel("section-content")
            ->setInitial($content)
            ->build();

        $this->addWritable($content);

        return $this;
    }

    /**
     * @param string $class
     * @return $this
     */
    public function addBreak($class = '')
    {
        $contentBuilder = SectionBuilder::begin()
            ->setType(SectionBuilder::TYPE_BREAK);

        if ($class !== '') {
            $contentBuilder->addClass($class);
        }

        $this->addWritable($contentBuilder->build());

        return $this;
    }

    /**
     * @param WritableBearerInterface $writableBearer
     * @param string                  $name
     * @return $this
     */
    public function addWritableBearer(WritableBearerInterface $writableBearer, $name = "")
    {
        $this->getWritableBearerBuilder()->addWritableBearer($writableBearer, $name);
        return $this;
    }
}
