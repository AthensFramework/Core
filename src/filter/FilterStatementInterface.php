<?php

namespace UWDOEM\Framework\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;


interface FilterStatementInterface {

    const COND_SORT_ASC = 1;
    const COND_SORT_DESC = 2;
    const COND_LESS_THAN = 3;
    const COND_GREATER_THAN = 4;
    const COND_EQUAL_TO = 5;
    const COND_NOT_EQUAL_TO = 6;
    const COND_PAGINATE_BY = 7;
    const COND_TRUTHY = 8;
    const COND_FALSEY = 9;

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