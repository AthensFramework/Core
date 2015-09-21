<?php

use UWDOEM\Framework\Filter\FilterStatement;


class FilterTest extends PHPUnit_Framework_TestCase {

    public function testFilterStatement() {
        $fieldName = (string)rand();
        $condition = (string)rand();
        $criterion = (string)rand();

        $filterStatement = new FilterStatement($fieldName, $condition, $criterion);

        $this->assertEquals($fieldName, $filterStatement->getFieldName());
        $this->assertEquals($condition, $filterStatement->getCondition());
        $this->assertEquals($criterion, $filterStatement->getCriterion());
    }

}

