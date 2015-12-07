<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Form\FormInterface;

interface PickAFormInterface extends FormInterface, PickAInterface
{

    /** @return FormInterface */
    public function getSelectedForm();

    /** @return string */
    public function getSelectedSlug();
}
