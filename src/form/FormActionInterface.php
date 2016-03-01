<?php

namespace Athens\Core\Form\FormAction;

use Athens\Core\Writer\WritableInterface;

/**
 * Interface FormActionInterface
 *
 * @package Athens\Core\Form\FormAction
 */
interface FormActionInterface extends WritableInterface
{

    /**
     * @return string
     */
    public function getMethod();

    /**
     * @return string
     */
    public function getTarget();

    /**
     * @return string
     */
    public function getLabel();
}
