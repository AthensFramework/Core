<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\Filter\FilterControls;
use UWDOEM\Framework\FilterStatement\ExcludingFilterStatement;


class SearchFilter extends Filter {

    /**
     * @param $handle
     * @param \UWDOEM\Framework\FilterStatement\FilterStatementInterface[] $statements
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($handle, array $statements, FilterInterface $nextFilter = null) {

        for($i=0;$i<=5;$i++) {
            $fieldname = FilterControls::getControl($handle, "fieldname$i");
            $operation = FilterControls::getControl($handle, "operation$i");
            $value = FilterControls::getControl($handle, "value$i");

            if ($fieldname && $operation && $value) {
                $statements[] = new ExcludingFilterStatement($fieldname, $operation, $value, null);
            }

        }

        $this->_feedback = "";
        foreach ($statements as $statement) {
            $fieldname = $statement->getFieldName();
            $value = $statement->getCriterion();
            $operation = $statement->getCondition();

            $this->_feedback .= $this->_feedback ? ", " : "";
            $this->_feedback .= $fieldname . " " . $operation . " " . $value;
        }
        parent::__construct($handle, $statements, $nextFilter);
    }

    /**
     * @param \UWDOEM\Framework\Row\RowInterface[] $rows
     */
    protected function setOptionsByRows(array $rows) {
        if (sizeof($rows) >= 1) {
            $this->_options = $rows[0]->getFieldBearer()->getFieldNames();
        }
    }
}