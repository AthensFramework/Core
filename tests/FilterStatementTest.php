<?php

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\Connection\ConnectionInterface;

use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEMTest\TestClassQuery;
use UWDOEM\Framework\Row\RowBuilder;
use UWDOEM\Framework\FieldBearer\FieldBearerBuilder;
use UWDOEM\Framework\Field\Field;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;
use UWDOEM\Framework\FilterStatement\ExcludingFilterStatement;
use UWDOEM\Framework\FilterStatement\PaginationFilterStatement;


class MockQuery extends TestClassQuery {
    public $orderByStatements = [];
    public $aliasedStatements = [];

    public $setOffset;
    public $setLimit;

    public $count;

    public function orderBy($columnName, $order = Criteria::ASC) {
        $this->orderByStatements[] = [$columnName, $order];
        return $this;
    }

    public function filterBy($column, $value, $comparison = Criteria::EQUAL) {
        $this->aliasedStatements[] = [$column, $value, $comparison];
        return $this;
    }

    public function addUsingAlias($p1, $value = null, $operator = null) {
        $this->aliasedStatements[] = [$p1, $value, $operator];
        return $this;
    }

    public function limit($limit) {
        $this->setLimit = $limit;
        return $this;
    }

    public function offset($offset) {
        $this->setOffset = $offset;
        return $this;
    }

    public function count(ConnectionInterface $con = null) {
        if (isset($this->count)) {
            return $this->count;
        } else {
            return parent::count($con);
        }
    }


}


class RowMaker {

    const INT_FIELD_NAME = "FirstField";
    const STRING_FIELD_NAME = "SecondField";
    
    /**
     * @return RowInterface[]
     * @throws Exception
     */
    public static function makeRows() {
        $rows = [];
        for ($i = 0; $i < 100; $i++) {

            $fieldBearer = FieldBearerBuilder::begin()
                ->addFields([
                    RowMaker::INT_FIELD_NAME => new Field("literal", "a literal field", rand(1, 100)),
                    RowMaker::STRING_FIELD_NAME => new Field("literal", "a literal field", (string)rand())
                ])
                ->build();

            $rows[] = RowBuilder::begin()
                ->setFieldBearer($fieldBearer)
                ->build();
        }
        return $rows;
    }

    /**
     * Takes a small sample from the given rows' int fields and produces the median of that sample.
     *
     * Useful for finding an int field that is neither the greatest nor smallest among the rows.
     *
     * @param RowInterface[] $rows
     * @return int
     */
    public static function sampleMedianIntField(array $rows) {
        $rand_keys = array_rand($rows, 5);

        $vals = array_map(
            function($key) use ($rows) {
                return $rows[$key]->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();
            },
            $rand_keys
        );

        sort($vals);
        return ($vals[2]);
    }
}



class FilterStatementTest extends PHPUnit_Framework_TestCase {

    protected $conditions = [
        FilterStatement::COND_SORT_ASC,
        FilterStatement::COND_SORT_DESC,
        FilterStatement::COND_LESS_THAN,
        FilterStatement::COND_GREATER_THAN,
        FilterStatement::COND_EQUAL_TO,
        FilterStatement::COND_NOT_EQUAL_TO,
        FilterStatement::COND_PAGINATE_BY,
    ];

    public function testFilterStatementConstruction() {
        $fieldName = (string)rand();
        $condition = (string)rand();
        $criterion = (string)rand();

        $statement = new ExcludingFilterStatement($fieldName, $condition, $criterion, null);

        $this->assertEquals($fieldName, $statement->getFieldName());
        $this->assertEquals($condition, $statement->getCondition());
        $this->assertEquals($criterion, $statement->getCriterion());
    }

    public function testRowFilterSortAscending() {
        $rows = RowMaker::makeRows();

        $statement = new SortingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_SORT_ASC,
            null,
            null
        );

        $rows = $statement->applyToRows($rows);

        $lastNumber = -1;
        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();

            $this->assertGreaterThanOrEqual($lastNumber, $thisNumber);

            $lastNumber = $thisNumber;
        }
    }

    public function testRowFilterSortDescending() {
        $rows = RowMaker::makeRows();

        $statement = new SortingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_SORT_DESC,
            null,
            null
        );

        $rows = $statement->applyToRows($rows);

        $lastNumber = getrandmax() + 1;
        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();

            $this->assertLessThanOrEqual($lastNumber, $thisNumber);

            $lastNumber = $thisNumber;
        }
    }

    public function testRowFilterLessThan() {
        $rows = RowMaker::makeRows();

        $criterion = RowMaker::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_LESS_THAN,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();
            $this->assertLessThan($criterion, $thisNumber);
        }
    }

    public function testRowFilterGreaterThan() {

        $rows = RowMaker::makeRows();

        $criterion = RowMaker::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_GREATER_THAN,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();
            $this->assertGreaterThan($criterion, $thisNumber);
        }

    }

    public function testRowFilterEqualTo() {
        $rows = RowMaker::makeRows();

        $criterion = RowMaker::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_EQUAL_TO,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();
            $this->assertEquals($criterion, $thisNumber);
        }
    }

    public function testRowFilterNotEqualTo() {
        $rows = RowMaker::makeRows();

        $criterion = RowMaker::sampleMedianIntField($rows);

        $statement = new ExcludingFilterStatement(
            RowMaker::INT_FIELD_NAME,
            FilterStatement::COND_NOT_EQUAL_TO,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::INT_FIELD_NAME)->getInitial();
            $this->assertNotEquals($criterion, $thisNumber);
        }
    }

    public function testRowFilterContains() {
        $rows = RowMaker::makeRows();

        $criterion = (string)rand(0,9);

        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_CONTAINS,
            $criterion,
            null
        );

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $thisNumber = $row->getFieldBearer()->getFieldByName(RowMaker::STRING_FIELD_NAME)->getInitial();
            $this->assertContains($criterion, $thisNumber);
        }

        // Sanity check, assert that at least SOME rows were returned by our filter
        $this->assertNotEmpty($rows);
    }

    public function testRowFilterPaginateBy() {
        $rows = RowMaker::makeRows();

        $maxPerPage = rand(2,9);
        $page = rand(2, 9);

        $statement = new PaginationFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_PAGINATE_BY,
            $maxPerPage,
            $page
        );

        $expectedRows = array_slice($rows, ($page - 1)*$maxPerPage, $maxPerPage);

        $rows = $statement->applyToRows($rows);

        foreach ($rows as $row) {
            $this->assertContains($row, $expectedRows);
        }

        // Sanity check, assert that at least SOME rows were returned by our filter
        $this->assertSameSize($rows, $expectedRows);
    }

    public function testQueryFilterSortAscending() {
        $query = new MockQuery();
        $statement = new SortingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_SORT_ASC,
            null,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, Criteria::ASC],
            $query->orderByStatements
        );
    }

    public function testQueryFilterSortDescending() {
        $query = new MockQuery();
        $statement = new SortingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_SORT_DESC,
            null,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, Criteria::DESC],
            $query->orderByStatements
        );
    }

    public function testQueryFilterLessThan() {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_LESS_THAN,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, $criterion, Criteria::LESS_THAN],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterGreaterThan() {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_GREATER_THAN,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, $criterion, Criteria::GREATER_THAN],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterEqualTo() {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_EQUAL_TO,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, $criterion, Criteria::EQUAL],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterNotEqualTo() {
        $query = new MockQuery();
        $criterion = rand();
        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_NOT_EQUAL_TO,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);

        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, $criterion, Criteria::NOT_EQUAL],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterContains() {
        $query = new MockQuery();
        $criterion = rand();

        $statement = new ExcludingFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_CONTAINS,
            $criterion,
            null
        );

        $query = $statement->applyToQuery($query);
        
        $this->assertContains(
            [RowMaker::STRING_FIELD_NAME, "%$criterion%", Criteria::LIKE],
            $query->aliasedStatements
        );
    }

    public function testQueryFilterPaginateBy() {
        /** @var MockQuery $query */
        $query = new MockQuery();

        $maxPerPage = rand(0,9);
        $page = rand(1,9);

        $statement = new PaginationFilterStatement(
            RowMaker::STRING_FIELD_NAME,
            FilterStatement::COND_PAGINATE_BY,
            $maxPerPage,
            $page
        );

        $query = $statement->applyToQuery($query);

        $this->assertEquals($maxPerPage, $query->setLimit);
        $this->assertEquals(($page - 1)*$maxPerPage, $query->setOffset);
    }


}