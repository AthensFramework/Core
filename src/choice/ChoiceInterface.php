<?php

namespace Athens\Core\Choice;

use Athens\Core\Writer\WritableInterface;

/**
 * Interface ChoiceInterface describes a small, typed data container for elements
 * that may be chosen among.
 *
 * An array satisfying ChoiceInterface[] would typically be provided to the
 * constructor of a FieldInterface. In HTML, this would be rendered as a <select>
 * field with a set of <option> elements.
 *
 * @package Athens\Core\Choice
 */
interface ChoiceInterface extends WritableInterface
{

    /** @return string */
    public function getKey();

    /** @return string */
    public function getValue();
}
