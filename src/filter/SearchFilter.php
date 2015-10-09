<?php

namespace UWDOEM\Framework\Filter;


class SearchFilter extends Filter {

    /**
     * @param \UWDOEM\Framework\Row\RowInterface[] $rows
     */
    protected function setOptionsByRows(array $rows) {
        if (sizeof($rows) >= 1) {
            $this->_options = $rows[0]->getFieldBearer()->getFieldNames();
        }
    }
}