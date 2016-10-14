<?php

namespace Athens\Core\ORMWrapper;

use Athens\Core\Choice\ChoiceBuilder;
use Athens\Core\Choice\ChoiceInterface;

/**
 * Class AbstractCollectionWrapper
 *
 * @package Athens\Core\ORMWrapper
 */
abstract class AbstractCollectionWrapper implements CollectionWrapperInterface
{

    /**
     * @return ChoiceInterface[]
     */
    public function getChoices()
    {
        /** @var ChoiceInterface[] $choices */
        $choices = [];
        foreach ($this as $object) {
            $choices[] = ChoiceBuilder::begin()
                ->setValue($object)
                ->addData('primary-key-for', $object->getPrimaryKey())
                ->build();
        }

        return $choices;
    }
}
