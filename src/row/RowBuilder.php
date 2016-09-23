<?php

namespace Athens\Core\Row;

use Propel\Runtime\ActiveRecord\ActiveRecordInterface;

use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;
use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Writable\WritableInterface;
use Athens\Core\Etc\ORMUtils;
use Athens\Core\Etc\StringUtils;

/**
 * Class RowBuilder
 * @package Athens\Core\Row
 */
class RowBuilder extends AbstractWritableBuilder
{

    /** @var string */
    protected $onClick;

    /** @var boolean */
    protected $highlightable = false;

    /** @var string[] */
    protected $labels = [];

    use WritableBearerBearerBuilderTrait {
        WritableBearerBearerBuilderTrait::addWritable as writableBearerBearerBuilderTraitAddWritable;
    }

    /**
     * @param WritableInterface $writable
     * @param string            $label
     * @param string            $name
     * @return $this
     */
    public function addWritable(WritableInterface $writable, $label = null, $name = null)
    {
        $this->writableBearerBearerBuilderTraitAddWritable($writable, $name);

        if ($label === null) {
            $label = method_exists($writable, 'getLabel') === true ? $writable->getLabel() : "";
        }

        $this->labels[$name] = $label;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeWritable($name)
    {
        $this->getWritableBearerBuilder()->removeWritable($name);
        $this->labels = array_diff_key($this->labels, [$name => '']);

        return $this;
    }

    /**
     * @param string[] $writableNames
     * @return $this
     */
    public function intersectWritableNames(array $writableNames)
    {
        $this->getWritableBearerBuilder()->intersectWritableNames($writableNames);

        $this->labels = array_intersect_key(
            $this->labels,
            array_flip($writableNames)
        );

        return $this;
    }

    /**
     * @param ActiveRecordInterface $object
     * @return $this
     */
    public function addObject(ActiveRecordInterface $object)
    {
        $spans = ORMUtils::makeSpansFromObject($object);
        $labels = ORMUtils::makeLabelsFromObject($object);

        foreach ($spans as $name => $span) {
            $this->addWritable($span, $labels[$name], $name);
        }

        return $this;
    }

    /**
     * @param string $onClick
     * @return RowBuilder
     */
    public function setOnClick($onClick)
    {
        $this->onClick = $onClick;
        return $this;
    }

    /**
     * @param boolean $highlightable
     * @return RowBuilder
     */
    public function setHighlightable($highlightable)
    {
        $this->highlightable = $highlightable;
        return $this;
    }

    /**
     * @return Row
     * @throws \Exception If the developer tries to give a highlightable row an onClick.
     */
    public function build()
    {
        $writableBearer = $this->buildWritableBearer();

        if (sizeof($writableBearer->getWritables()) === 0) {
            throw new \RuntimeException(
                "You must specify an implementation of " .
                "WritableBearerInterface using ::setWritableBearer before calling this method."
            );
        }

        if ($this->highlightable === true && $this->onClick !== null) {
            throw new \Exception("You cannot both make a row highlightable and provide an onClick.");
        }

        if ($this->highlightable === true) {
            $this->onClick = "athens.highlightRow(this)";
        }

        return new Row(
            $this->classes,
            $this->data,
            $writableBearer,
            $this->labels,
            $this->onClick,
            $this->highlightable
        );
    }
}
