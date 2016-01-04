<?php

namespace UWDOEM\Framework\Form\FormAction;

use UWDOEM\Framework\Writer\WritableInterface;

/**
 * Interface FormActionInterface
 *
 * @package UWDOEM\Framework\Form\FormAction
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
