<?php

namespace Athens\Core\Filter;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;

/**
 * Class SortFilter
 * @package Athens\Core\Filter
 */
class SortFilter extends Filter
{

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param array                $data
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($id, array $classes, array $data, FilterInterface $nextFilter = null)
    {

        $statements = [];
        if (FilterControls::controlIsSet($id, "fieldname") === true) {
            $fieldName = FilterControls::getControl($id, "fieldname");
            $order = FilterControls::getControl($id, "order", FilterStatement::COND_SORT_ASC);

            $statements[] = new SortingFilterStatement($fieldName, $order, null, null);
        }

        parent::__construct($id, $classes, $data, $statements, $nextFilter);
    }


//    Joe start here


//    Joe end here
}
