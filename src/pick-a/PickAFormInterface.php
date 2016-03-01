<?php

namespace Athens\Core\PickA;

use Athens\Core\Form\FormInterface;

interface PickAFormInterface extends FormInterface, PickAInterface
{

    /** @return FormInterface */
    public function getSelectedForm();

    /** @return string */
    public function getSelectedSlug();
}
