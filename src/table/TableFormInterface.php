<?php

namespace Athens\Core\Table;

use Athens\Core\Form\FormInterface;

interface TableFormInterface extends TableInterface, FormInterface
{

    /** @return \Athens\Core\Row\RowInterface */
    public function getPrototypicalRow();

    /** @return boolean */
    public function getCanRemove();
}
