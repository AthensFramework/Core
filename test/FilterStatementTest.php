<?php

namespace Athens\Core\Test;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;
use Athens\Core\FilterStatement\ExcludingFilterStatement;
use Athens\Core\FilterStatement\PaginationFilterStatement;

use Athens\Core\Test\Mock\MockQueryWrapper;

class FilterStatementTest extends TestCase
{
    public function setUp()
    {
        $this->createORMFixtures();
    }

    public function testFilterStatementConstruction()
    {
        $fieldName = (string)rand();
        $condition = (string)rand();
        $criterion = (string)rand();

        $statement = new ExcludingFilterStatement($fieldName, $condition, $criterion, null);

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($condition, $statement->getCondition());
        $this->assertEquals($criterion, $statement->getCriterion());
    }

    public function testRowFilterSortAscending()
    {
        $rows = Utils::makeRows();

        $statement = new SortingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_SORT_ASC,
            null,
            null
        );

        $rows = $statement->applyToRows($rows);

        $lastNumber = -1;
        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();

            $this->assertGreaterThanOrEqual($lastNumber, $thisNumber);

            $lastNumber = $thisNumber;
        }
    }

    public function testRowFilterSortDescending()
    {
        $rows = Utils::makeRows();

        $statement = new SortingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_SORT_DESC,
            null,
            null
        );

        $rows = $statement->applyToRows($rows);

        $lastNumber = getrandmax() + 1;
        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();

            $this->assertLessThanOrEqual($lastNumber, $thisNumber);

            $lastNumber = $thisNumber;
        }
    }

    public function testRowFilterLessThan()
    {
        $rows = Utils::makeRows();

        $criterion = Utils::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_LESS_THAN,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();
            $this->assertLessThan($criterion, $thisNumber);
        }
    }

    public function testRowFilterGreaterThan()
    {

        $rows = Utils::makeRows();

        $criterion = Utils::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_GREATER_THAN,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();
            $this->assertGreaterThan($criterion, $thisNumber);
        }
    }

    public function testRowFilterEqualTo()
    {
        $rows = Utils::makeRows();

        $criterion = Utils::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_EQUAL_TO,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();
            $this->assertEquals($criterion, $thisNumber);
        }
    }

    public function testRowFilterNotEqualTo()
    {
        $rows = Utils::makeRows();

        $criterion = (string)Utils::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            Utils::INT_FIELD_NAME,
            FilterStatement::COND_NOT_EQUAL_TO,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::INT_FIELD_NAME)->getInitial();
            $this->assertNotEquals($criterion, $thisNumber);
        }
    }

    public function testRowFilterContains()
    {
        $rows = Utils::makeRows();

        $criterion = (string)rand(0, 9);

        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_CONTAINS,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getWritableBearer()->getWritableByHandle(Utils::STRING_FIELD_NAME)->getInitial();
            $this->assertContains($criterion, $thisNumber);
        }

        // Sanity check, assert that at least SOME rows were returned by our filter
        $this->assertNotEmpty($rows);
    }

    /**
     * If a pagination filter is forced to filter by row, then we want it
     * to perform soft pagination: return all rows and let javascript perform
     * the pagination.
     */
    public function testRowFilterPaginateBy()
    {
        $rows = Utils::makeRows();

        $maxPerPage = rand(2, 9);
        $page = rand(2, 9);

        $statement = new PaginationFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_PAGINATE_BY,
            $maxPerPage,
            $page
        );

        $expectedRows = $rows;

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $this->assertContains($row, $expectedRows);
        }

        // Sanity check, assert that at least SOME rows were returned by our filter
        $this->assertSameSize($rows, $expectedRows);
    }

    public function testQueryOrderBy()
    {
        $fieldName = 'f' . (string)rand();
        $criteria = 'c' . (string)rand();

        $statement = new SortingFilterStatement(
            $fieldName,
            $criteria,
            null,
            null
        );

        $this->query->expects($this->once())
            ->method('orderBy')
            ->with(
                $this->equalTo($fieldName),
                $this->equalTo($criteria)
            );

        $statement->applyToQuery(new MockQueryWrapper($this->query));
    }

    public function testQueryFilterBy()
    {
        $fieldName = 'f' . (string)rand();
        $criteria = 'c' . (string)rand();
        $criterion = 'c' . (string)rand();

        $statement = new ExcludingFilterStatement(
            $fieldName,
            $criteria,
            $criterion,
            null
        );

        $this->query->expects($this->once())
            ->method('filterBy')
            ->with(
                $this->equalTo($fieldName),
                $this->equalTo($criteria),
                $this->equalTo($criterion)
            );

        $statement->applyToQuery(new MockQueryWrapper($this->query));
    }

    public function testQueryFilterPaginateBy()
    {
        $maxPerPage = rand(0, 9);
        $page = rand(1, 9);

        $statement = new PaginationFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_PAGINATE_BY,
            $maxPerPage,
            $page
        );
        
        $expectedLimit = $maxPerPage;
        $expectedOffset = ($page - 1)*$maxPerPage;

        $this->query->expects($this->once())
            ->method('offset')
            ->with($this->equalTo($expectedOffset));

        $this->query->expects($this->once())
            ->method('limit')
            ->with($this->equalTo($expectedLimit));

        $statement->applyToQuery(new MockQueryWrapper($this->query));
    }
}
