<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;

/**
 * Class SortFilter
 * @package UWDOEM\Framework\Filter
 */
class SortFilter extends Filter
{

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($id, array $classes, FilterInterface $nextFilter = null)
    {

        $statements = [];
        if (FilterControls::controlIsSet($id, "fieldname") === true) {
            $fieldName = FilterControls::getControl($id, "fieldname");
            $order = FilterControls::getControl($id, "order", FilterStatement::COND_SORT_ASC);

            $statements[] = new SortingFilterStatement($fieldName, $order, null, null);
        }

        parent::__construct($id, $classes, $statements, $nextFilter);
    }
}
