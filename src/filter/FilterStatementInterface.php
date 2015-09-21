<?php

namespace UWDOEM\Framework\Filter;


interface FilterStatementInterface {

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