<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\Filter\FilterBuilder;
use Athens\Core\Filter\Filter;
use Athens\Core\Settings\Settings;
use Athens\Core\Filter\PaginationFilter;
use Athens\Core\Filter\FilterControls;
use Athens\Core\Filter\SortFilter;
use Athens\Core\Row\RowBuilder;
use Athens\Core\Field\Field;

use Athens\Core\Test\Mock\MockQuery;

class FilterTest extends PHPUnit_Framework_TestCase
{

    protected $conditions = [
        FilterStatement::COND_SORT_ASC,
        FilterStatement::COND_SORT_DESC,
        FilterStatement::COND_LESS_THAN,
        FilterStatement::COND_GREATER_THAN,
        FilterStatement::COND_EQUAL_TO,
        FilterStatement::COND_NOT_EQUAL_TO,
        FilterStatement::COND_PAGINATE_BY,
        FilterStatement::COND_ALL,
    ];

    public function testBuildStaticFilter()
    {

        $fieldName = (string)rand();
        $condition = array_rand(array_flip($this->conditions), 1);
        $criterion = (string)rand();
        $handle = (string)rand();
        $classes = [(string)rand(), (string)rand()];

        $filter = FilterBuilder::begin()
            ->setType(Filter::TYPE_STATIC)
            ->setId($handle)
            ->addClass($classes[0])
            ->addClass($classes[1])
            ->setFieldName($fieldName)
            ->setCondition($condition)
            ->setCriterion($criterion)
            ->build();

        $this->assertEquals($handle, $filter->getId());
        $this->assertEquals($classes, $filter->getClasses());
        $this->assertEquals(1, sizeof($filter->getStatements()));

        $statement = $filter->getStatements()[0];

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($condition, $statement->getCondition());
        $this->assertEquals($criterion, $statement->getCriterion());
    }

    public function testRowFilter()
    {
        $fieldValues = [1, 3];
        $fieldName = "field" . (string)rand();

        $rows = [];

        // Make one row for each of the field values
        foreach ($fieldValues as $fieldValue) {
            $rows[] = RowBuilder::begin()
                ->addWritable(new Field([], [], 'literal', 'A literal field', $fieldValue), $fieldName, $fieldName)
                ->build();
        }

        $filter = FilterBuilder::begin()
            ->setId("myFilter")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName($fieldName)
            ->setCondition(FilterStatement::COND_GREATER_THAN)
            ->setCriterion(2)
            ->build();

        $this->assertEquals(1, sizeof($filter->getStatements()));
        $this->assertEquals(1, sizeof($filter->rowFilter($rows)));
    }

    public function testBuildPaginationFilter()
    {
        $maxPerPage = rand();
        $page = rand();
        $handle = (string)rand();
        $type = Filter::TYPE_PAGINATION;

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setId($handle)
            ->setPage($page)
            ->setMaxPerPage($maxPerPage)
            ->build();

        $this->assertEquals($handle, $filter->getId());
        $this->assertTrue($filter instanceof PaginationFilter);
        $this->assertEquals(1, sizeof($filter->getStatements()));

        $statement = $filter->getStatements()[0];

        // Assert that the filter statement was created correctly
        $this->assertEquals(FilterStatement::COND_PAGINATE_BY, $statement->getCondition());
        $this->assertEquals($maxPerPage, $statement->getCriterion());
        $this->assertEquals($page, $statement->getControl());
    }

    public function testBuildSortFilter()
    {
        $handle = (string)rand();
        $type = Filter::TYPE_SORT;

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setId($handle)
            ->build();

        $this->assertEquals($handle, $filter->getId());
        $this->assertTrue($filter instanceof SortFilter);

        // No controls set for this filter, hence no statements
        $this->assertEquals(0, sizeof($filter->getStatements()));
    }

    public function testSortFilterUsesControl()
    {
        $handle = (string)rand();
        $type = Filter::TYPE_SORT;

        $fieldName = (string)rand();
        $order = FilterStatement::COND_SORT_DESC;

        $_GET["$handle-fieldname"] = $fieldName;
        $_GET["$handle-order"] = $order;

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setId($handle)
            ->build();

        $this->assertEquals(1, sizeof($filter->getStatements()));

        $statement = $filter->getStatements()[0];

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($order, $statement->getCondition());
    }

    public function testBuildPaginationFilterUsesPaginateSetting()
    {
        $paginateBy = rand();
        $handle = (string)rand();
        $type = Filter::TYPE_PAGINATION;

        // Store the current default pagination
        $defaultPagination = Settings::getInstance()->getDefaultPagination();

        // Set our new pagination
        Settings::getInstance()->setDefaultPagination($paginateBy);

        $filter = FilterBuilder::begin()
            ->setType($type)
            ->setId($handle)
            ->build();

        $this->assertEquals(1, sizeof($filter->getStatements()));

        $this->assertEquals($handle, $filter->getId());
        $this->assertTrue($filter instanceof PaginationFilter);
        $statement = $filter->getStatements()[0];

        $this->assertEquals(FilterStatement::COND_PAGINATE_BY, $statement->getCondition());
        $this->assertEquals($paginateBy, $statement->getCriterion());

        // Return the old default pagination
        Settings::getInstance()->setDefaultPagination($defaultPagination);
    }

    /**
     * @expectedException              \Exception
     * @expectedExceptionMessageRegExp #Must use ::setId to provide a unique id.*#
     */
    public function testBuildFilterErrorWithoutHandle()
    {
        $filter = FilterBuilder::begin()
            ->setType(Filter::TYPE_PAGINATION)
            ->build();
    }

    public function testPaginationFilterOptions()
    {
        $maxPerPage = rand(5, 15);
        $count = rand(50, 200);

        $filter = FilterBuilder::begin()
            ->setId("pagination")
            ->setMaxPerPage($maxPerPage)
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        $query = new MockQuery();
        $query->count = $count;

        $filter->queryFilter($query);

        $expectedNumPages = ceil($count/$maxPerPage);

        $this->assertEquals(range(1, $expectedNumPages), $filter->getOptions());
    }

    public function testSelectFilterOptions()
    {
        $handle = (string)rand();

        $optionNames = ["s".(string)rand(), "s".(string)rand(), "s".(string)rand()];
        $optionFieldNames = [(string)rand(), (string)rand(), (string)rand()];
        $optionConditions = [
            FilterStatement::COND_GREATER_THAN,
            FilterStatement::COND_CONTAINS,
            FilterStatement::COND_LESS_THAN
        ];
        $optionValues = [rand(), rand(), rand()];

        $defaultOption = 1;

        $selectFilterBuilder = FilterBuilder::begin()
            ->setType(Filter::TYPE_SELECT)
            ->setId($handle)
            ->addOptions([
                $optionNames[0] => [$optionFieldNames[0], $optionConditions[0], $optionValues[0]],
                $optionNames[1] => [$optionFieldNames[1], $optionConditions[1], $optionValues[1]],
            ])
            ->addOptions([
                $optionNames[2] => [$optionFieldNames[2], $optionConditions[2], $optionValues[2]],
            ])
            ->setDefault($optionNames[$defaultOption]);
        
        // Build the filter, without a selection
        $filter1 = $selectFilterBuilder->build();

        // Assert that each option name is provided as a selectable option
        foreach ($optionNames as $name) {
            $this->assertContains($name, $filter1->getOptions());
        }

        // Assert that only one option is being used as a filter statement
        $this->assertEquals(1, sizeof($filter1->getStatements()));

        // Assert that this is the default option
        $statement = $filter1->getStatements()[0];

        $this->assertEquals($optionFieldNames[$defaultOption], $statement->getFieldName());
        $this->assertEquals($optionConditions[$defaultOption], $statement->getCondition());
        $this->assertEquals($optionValues[$defaultOption], $statement->getCriterion());
        
        // Now, build the filter with a selected option
        $selectedOption = 2;
        $_GET["$handle-value"] = $optionNames[$selectedOption];
        
        $filter2 = $selectFilterBuilder->build();

        // Assert that only one option is being used as a filter statement
        $this->assertEquals(1, sizeof($filter2->getStatements()));

        // Assert that this is the selected option
        $statement = $filter2->getStatements()[0];

        $this->assertEquals($optionFieldNames[$selectedOption], $statement->getFieldName());
        $this->assertEquals($optionConditions[$selectedOption], $statement->getCondition());
        $this->assertEquals($optionValues[$selectedOption], $statement->getCriterion());
    }

    public function testSearchFilterMakeOptions()
    {
        $filter = FilterBuilder::begin()
            ->setId("search")
            ->setType(Filter::TYPE_SEARCH)
            ->build();

        $field1 = new Field([], [], "text", "Text Field Label", (string)rand());
        $field1Name = "TextField1";
        $field2 = new Field([], [], "text", "Text Field Label", (string)rand());
        $field2Name = "TextField2";

        $row = RowBuilder::begin()
            ->addWritable($field1, $field1Name, $field1Name)
            ->addWritable($field2, $field2Name, $field2Name)
            ->build();

        $filter->rowFilter([$row]);

        $this->assertContains($field1Name, $filter->getOptions());
        $this->assertContains($field2Name, $filter->getOptions());
    }

    public function testPaginationFilterFeedback()
    {
        $maxPerPage = rand(5, 15);
        $count = rand(50, 200);

        $filter = FilterBuilder::begin()
            ->setId("pagination")
            ->setMaxPerPage($maxPerPage)
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        $query = new MockQuery();
        $query->count = $count;

        $filter->queryFilter($query);

        $expectedNumPages = ceil($count/$maxPerPage);

        $this->assertContains((string)$count, $filter->getFeedback());
    }

    public function testBuildFilterWithNextFilter()
    {
        $filter1 = FilterBuilder::begin()
            ->setId("Filter1")
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        $filter2 = FilterBuilder::begin()
            ->setId("Filter2")
            ->setNextFilter($filter1)
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        $this->assertEquals($filter1, $filter2->getNextFilter());
    }

    public function testChainedFilterByQuery()
    {
        $filter1 = FilterBuilder::begin()
            ->setId("Filter1")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.Id")
            ->setCondition(FilterStatement::COND_SORT_ASC)
            ->build();

        $filter2 = FilterBuilder::begin()
            ->setNextFilter($filter1)
            ->setId("Filter2")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.FieldFloat")
            ->setCondition(FilterStatement::COND_SORT_DESC)
            ->build();

        // use MockQuery from FilterStatementTest
        $query = new MockQuery();
        $query = $filter2->queryFilter($query);

        $this->assertContains(["TestClass.Id", "ASC"], $query->orderByStatements);
        $this->assertContains(["TestClass.FieldFloat", "DESC"], $query->orderByStatements);
    }

    public function testForceFilterByRow()
    {
        $filter1 = FilterBuilder::begin()
            ->setId("Filter1")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.Id")
            ->setCondition(FilterStatement::COND_SORT_ASC)
            ->build();

        // This filter will force a row sort because the field name is not
        // available to the query.
        $filter2 = FilterBuilder::begin()
            ->setNextFilter($filter1)
            ->setId("Filter2")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.MadeUpFieldToForceRowSort")
            ->setCondition(FilterStatement::COND_SORT_DESC)
            ->build();

        // This filter could be done by query, except that the previous
        // filter has forced the whole chain into row-filtering.
        $filter3 = FilterBuilder::begin()
            ->setNextFilter($filter2)
            ->setId("Filter3")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.FieldFloat")
            ->setCondition(FilterStatement::COND_SORT_DESC)
            ->build();

        // use MockQuery from FilterStatementTest
        $query = new MockQuery();
        $query = $filter3->queryFilter($query);

        $this->assertContains(["TestClass.Id", "ASC"], $query->orderByStatements);
        $this->assertEquals(1, sizeof($query->orderByStatements));
    }

    public function testForcePaginationFilterToSoftPagination()
    {
        // This pagination filter should be able to execute by query, so it should remain
        // a hard pagination filter.
        $filter1 = FilterBuilder::begin()
            ->setId("Filter1")
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        // This filter will force a row sort because the field name is not
        // available to the query.
        $filter2 = FilterBuilder::begin()
            ->setNextFilter($filter1)
            ->setId("Filter2")
            ->setType(Filter::TYPE_STATIC)
            ->setFieldName("TestClass.MadeUpFieldToForceRowSort")
            ->setCondition(FilterStatement::COND_SORT_DESC)
            ->build();

        // This pagination filter will be forced to be done by rows, which means
        // that it should designate itself as a soft pagination filter.
        $filter3 = FilterBuilder::begin()
            ->setNextFilter($filter2)
            ->setId("Filter3")
            ->setType(Filter::TYPE_PAGINATION)
            ->build();

        // use MockQuery from FilterStatementTest
        $query = new MockQuery();
        $query->count = 10;
        $query = $filter3->queryFilter($query);

        $filter3->rowFilter([]);

        $this->assertEquals(PaginationFilter::TYPE_HARD_PAGINATION, $filter1->getType());
        $this->assertEquals(PaginationFilter::TYPE_SOFT_PAGINATION, $filter3->getType());
    }

    public function testFilterControlsFromGet()
    {
        $handle = (string)rand();
        $key = (string)rand();
        $value = (string)rand();

        $_GET["$handle-$key"] = $value;

        $this->assertEquals($value, FilterControls::getControl($handle, $key));
    }

    public function testFilterControlsIsSet()
    {
        $handle = (string)rand();
        $key = (string)rand();
        $value = (string)rand();

        $this->assertFalse(FilterControls::controlIsSet($handle, $key));

        $_GET["$handle-$key"] = $value;

        $this->assertTrue(FilterControls::controlIsSet($handle, $key));
    }

    public function testFilterControlsFromDefault()
    {
        $handle = (string)rand();
        $key = (string)rand();
        $default = (string)rand();

        $this->assertEquals($default, FilterControls::getControl($handle, $key, $default));
    }
}
