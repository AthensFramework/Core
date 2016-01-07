<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Form\FormInterface;

interface TableFormInterface extends TableInterface, FormInterface
{

    /** @return \UWDOEM\Framework\Row\RowInterface */
    public function getPrototypicalRow();

    /** @return boolean */
    public function getCanRemove();
}
