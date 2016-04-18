<?php

namespace Athens\Core\Filter;

use Athens\Core\FilterStatement\ExcludingFilterStatement;
use Athens\Core\FilterStatement\FilterStatementInterface;

/**
 * Class SearchFilter
 *
 * @package Athens\Core\Filter
 */
class SearchFilter extends Filter
{

    /**
     * @param string                     $id
     * @param FilterStatementInterface[] $classes
     * @param FilterInterface|null       $nextFilter
     */
    public function __construct($id, array $classes, FilterInterface $nextFilter = null)
    {

        $statements = [];
        for ($i=0; $i<=5; $i++) {
            $fieldname = FilterControls::getControl($id, "fieldname$i");
            $operation = FilterControls::getControl($id, "operation$i");
            $value = FilterControls::getControl($id, "value$i");

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
        parent::__construct($id, $classes, $statements, $nextFilter);
    }

    /**
     * @param \Athens\Core\Row\RowInterface[] $rows
     * @return void
     */
    protected function setOptionsByRows(array $rows)
    {
        if (sizeof($rows) >= 1) {
            $this->options = $rows[0]->getFieldBearer()->getFieldNames();
        }
    }
}
