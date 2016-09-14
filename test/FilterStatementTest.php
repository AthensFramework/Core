<?php

namespace Athens\Core\Test;

use PHPUnit_Framework_TestCase;

use Propel\Runtime\ActiveQuery\Criteria;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;
use Athens\Core\FilterStatement\ExcludingFilterStatement;
use Athens\Core\FilterStatement\PaginationFilterStatement;

use Athens\Core\Test\Mock\MockQuery;

class FilterStatementTest extends PHPUnit_Framework_TestCase
{

    protected $conditions = [
        FilterStatement::COND_SORT_ASC,
        FilterStatement::COND_SORT_DESC,
        FilterStatement::COND_LESS_THAN,
        FilterStatement::COND_GREATER_THAN,
        FilterStatement::COND_EQUAL_TO,
        FilterStatement::COND_NOT_EQUAL_TO,
        FilterStatement::COND_PAGINATE_BY,
    ];

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

        $criterion = Utils::sampleMedianIntField($rows);

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

    public function testQueryFilterSortAscending()
    {
        $query = new MockQuery();
        $statement = new SortingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_SORT_ASC,
            null,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, Criteria::ASC],
            $query->orderByStatements
        );
    }

    public function testQueryFilterSortDescending()
    {
        $query = new MockQuery();
        $statement = new SortingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_SORT_DESC,
            null,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, Criteria::DESC],
            $query->orderByStatements
        );
    }

    public function testQueryFilterLessThan()
    {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_LESS_THAN,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, $criterion, Criteria::LESS_THAN],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterGreaterThan()
    {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_GREATER_THAN,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, $criterion, Criteria::GREATER_THAN],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterEqualTo()
    {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_EQUAL_TO,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, $criterion, Criteria::EQUAL],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterNotEqualTo()
    {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_NOT_EQUAL_TO,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, $criterion, Criteria::NOT_EQUAL],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterContains()
    {
        $query = new MockQuery();
        $criterion = rand();

        $statement = new ExcludingFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_CONTAINS,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [Utils::STRING_FIELD_NAME, "%$criterion%", Criteria::LIKE],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterPaginateBy()
    {
        /** @var MockQuery $query */
        $query = new MockQuery();

        $maxPerPage = rand(0, 9);
        $page = rand(1, 9);

        $statement = new PaginationFilterStatement(
            Utils::STRING_FIELD_NAME,
            FilterStatement::COND_PAGINATE_BY,
            $maxPerPage,
            $page
        );

        $query = $statement->applyToQuery($query);

        $this->assertEquals($maxPerPage, $query->setLimit);
        $this->assertEquals(($page - 1)*$maxPerPage, $query->setOffset);
    }
}
