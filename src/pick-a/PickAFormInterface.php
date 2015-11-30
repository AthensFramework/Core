<?php

namespace UWDOEM\Framework\PickA;

use UWDOEM\Framework\Form\FormInterface;


interface PickAFormInterface extends FormInterface, PickAInterface {

    /** @return FormInterface */
    function getSelectedForm();

    /** @return string */
    function getSelectedSlug();
}