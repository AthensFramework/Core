<?php

use UWDOEM\Framework\Filter\FilterStatement;

use UWDOEM\Framework\Filter\FilterBuilder;
use UWDOEM\Framework\Filter\Filter;
use UWDOEM\Framework\Etc\Settings;


class FilterTest extends PHPUnit_Framework_TestCase {

    protected $conditions = [
        FilterStatement::COND_SORT_ASC,
        FilterStatement::COND_SORT_DESC,
        FilterStatement::COND_LESS_THAN,
        FilterStatement::COND_GREATER_THAN,
        FilterStatement::COND_EQUAL_TO,
        FilterStatement::COND_NOT_EQUAL_TO,
        FilterStatement::COND_PAGINATE_BY,
        FilterStatement::COND_TRUTHY,
        FilterStatement::COND_FALSEY,
    ];


    public function testFilterStatement() {
        $fieldName = (string)rand();
        $condition = (string)rand();
        $criterion = (string)rand();

        $statement = new FilterStatement($fieldName, $condition, $criterion);

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($condition, $statement->getCondition());
        $this->assertEquals($criterion, $statement->getCriterion());
    }

    public function testBuildStaticFilter() {

        $fieldName = (string)rand();
        $condition = array_rand(array_flip($this->conditions), 1);
        $criterion = (string)rand();
        $handle = (string)rand();

        $filter = FilterBuilder::begin()
            ->setType(Filter::TYPE_STATIC)
            ->setHandle($handle)
            ->setFieldName($fieldName)
            ->setCondition($condition)
            ->setCriterion($criterion)
            ->build();

        $this->assertEquals($handle, $filter->getHandle());
        $this->assertEquals(1, sizeof($filter->getStatements()));

        $statement = $filter->getStatements()[0];

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($condition, $statement->getCondition());
        $this->assertEquals($criterion, $statement->getCriterion());
    }

    public function testBuildPaginationFilter() {
        $paginateBy = rand();
        $handle = (string)rand();
        $type = Filter::TYPE_PAGINATION;

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setHandle($handle)
            ->setPaginateBy($paginateBy)
            ->build();

        $this->assertEquals($handle, $filter->getHandle());
        $this->assertEquals($type, $filter->getType());
        $this->assertEquals(1, sizeof($filter->getStatements()));

        $statement = $filter->getStatements()[0];

        $this->assertEquals(FilterStatement::COND_PAGINATE_BY, $statement->getCondition());
        $this->assertEquals($paginateBy, $statement->getCriterion());
    }

    public function testBuildPaginationFilterUsesPaginateSetting() {
        $paginateBy = rand();
        $handle = (string)rand();
        $type = Filter::TYPE_PAGINATION;

        // Store the current default pagination
        $defaultPagination = Settings::getDefaultPagination();

        // Set our new pagination
        Settings::setDefaultPagination($paginateBy);

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setHandle($handle)
            ->build();

        $this->assertEquals(1, sizeof($filter->getStatements()));

        $this->assertEquals($handle, $filter->getHandle());
        $this->assertEquals($type, $filter->getType());
        $statement = $filter->getStatements()[0];

        $this->assertEquals(FilterStatement::COND_PAGINATE_BY, $statement->getCondition());
        $this->assertEquals($paginateBy, $statement->getCriterion());

        // Return the old default pagination
        Settings::setDefaultPagination($defaultPagination);
    }

    /**
     * @expectedException              Exception
     * @expectedExceptionMessageRegExp #You must set _handle.*#
     */
    public function testBuildFilterErrorWithoutHandle() {
        $filter = FilterBuilder::begin()
            ->setType(Filter::TYPE_PAGINATION)
            ->build();
    }

}

