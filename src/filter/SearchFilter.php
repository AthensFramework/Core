<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\FilterStatement\ExcludingFilterStatement;

/**
 * Class SearchFilter
 *
 * @package UWDOEM\Framework\Filter
 */
class SearchFilter extends Filter
{

    /**
     * @param string               $handle
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($handle, FilterInterface $nextFilter = null)
    {

        $statements = [];
        for ($i=0; $i<=5; $i++) {
            $fieldname = FilterControls::getControl($handle, "fieldname$i");
            $operation = FilterControls::getControl($handle, "operation$i");
            $value = FilterControls::getControl($handle, "value$i");

            if ($fieldname !== "" && $operation !== "" && $value !== "") {
                $statements[] = new ExcludingFilterStatement($fieldname, $operation, $value, null);
            }

        }

        $this->feedback = "";
        foreach ($statements as $statement) {
            $fieldname = $statement->getFieldName();
            $value = $statement->getCriterion();
            $operation = $statement->getCondition();

            $this->feedback .= $this->feedback === "" ? ", " : "";
            $this->feedback .= $fieldname . " " . $operation . " " . $value;
        }
        parent::__construct($handle, $statements, $nextFilter);
    }

    /**
     * @param \UWDOEM\Framework\Row\RowInterface[] $rows
     * @return void
     */
    protected function setOptionsByRows(array $rows)
    {
        if (sizeof($rows) >= 1) {
            $this->options = $rows[0]->getFieldBearer()->getFieldNames();
        }
    }
}
