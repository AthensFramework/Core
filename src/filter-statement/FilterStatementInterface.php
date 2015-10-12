<?php

namespace UWDOEM\Framework\FilterStatement;

use Propel\Runtime\ActiveQuery\ModelCriteria;


interface FilterStatementInterface {

    const COND_SORT_ASC = "ascending";
    const COND_SORT_DESC = "descending";
    const COND_LESS_THAN = "LESS THAN";
    const COND_GREATER_THAN = "GREATER THAN";
    const COND_EQUAL_TO = "EQUAL TO";
    const COND_NOT_EQUAL_TO = "NOT EQUAL TO";
    const COND_CONTAINS = "CONTAINS";
    const COND_PAGINATE_BY = 8;

    /**
     * @return string
     */
    public function getFieldName();

    /**
     * @return string
     */
    public function getCondition();

    /**
     * @return mixed
     */
    public function getCriterion();

    /**
     * @return mixed
     */
    public function getControl();

    /**
     * @param ModelCriteria $query
     * @return ModelCriteria
     */
    public function applyToQuery(ModelCriteria $query);

    /**
     * @param \UWDOEM\Framework\Row\Row[] $rows
     * @return \UWDOEM\Framework\Row\Row[]
     */
    public function applyToRows(array $rows);

}