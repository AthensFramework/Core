<?php

namespace Athens\Core\FormAction;

use Athens\Core\Writable\WritableInterface;

/**
 * Interface FormActionInterface
 *
 * @package Athens\Core\Form\FormAction
 */
interface FormActionInterface extends WritableInterface, FormActionConstantsInterface
{

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getLabel();
}
