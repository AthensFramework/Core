<?php

namespace Athens\Core\Section;

use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\WritableBearer\WritableBearerBearerBuilderTrait;

/**
 * Class SectionBuilder
 *
 * @package Athens\Core\Section
 */
class SectionBuilder extends AbstractWritableBuilder implements SectionConstantsInterface
{
    /** @var string */
    protected $type = "base";
    
    use WritableBearerBearerBuilderTrait;

    /**
     * @param string $type
     * @return SectionBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return SectionInterface
     */
    public function build()
    {
        $writableBearer = $this->buildWritableBearer();

        return new Section($this->id, $this->classes, $this->data, $writableBearer, $this->type);
    }
}
