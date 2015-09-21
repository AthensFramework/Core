<?php

namespace UWDOEM\Framework\Filter;


interface FilterStatementInterface {

    const COND_SORT_ASC = 1;
    const COND_SORT_DESC = 2;
    const COND_LESS_THAN = 3;
    const COND_GREATER_THAN = 4;
    const COND_EQUAL_TO = 5;
    const COND_NOT_EQUAL_TO = 6;
    const COND_TRUTHY = 7;
    const COND_FALSEY = 8;

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

}