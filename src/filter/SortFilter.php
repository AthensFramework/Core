<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;


class SortFilter extends Filter {

    public function __construct($handle, FilterInterface $nextFilter = null) {

        $statements = [];
        if (FilterControls::controlIsSet($handle, "fieldname")) {
            $fieldName = FilterControls::getControl($handle, "fieldname");
            $order = FilterControls::getControl($handle, "order", FilterStatement::COND_SORT_ASC);

            $statements[] = new SortingFilterStatement($fieldName, $order, null, null);
        }

        parent::__construct($handle, $statements, $nextFilter);
    }

}