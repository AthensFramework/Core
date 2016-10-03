<?php

namespace Athens\Core\Filter;

use Athens\Core\ORMWrapper\ObjectWrapperInterface;
use Exception;

use Athens\Core\ORMWrapper\QueryWrapperInterface;
use Athens\Core\Row\RowInterface;

/**
 * Class RelationFilter
 *
 * @package Athens\Core\Filter
 */
class RelationFilter extends SelectFilter
{

    const ALL = 'All';
    const ANY = 'Any';
    const NONE = 'None';

    /** @var ObjectWrapperInterface[] */
    protected $relations = [];

    /** @var string */
    protected $relationName = '';

    /**
     * @param string                $id
     * @param string[]              $classes
     * @param string[]              $data
     * @param QueryWrapperInterface $query
     * @param string                $default
     * @param FilterInterface|null  $nextFilter
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        QueryWrapperInterface $query,
        $default,
        FilterInterface $nextFilter = null
    ) {
        $this->relationName = array_slice(explode('\\', $query->getPascalCasedObjectName()), -1)[0];

        $relations = $query->find();

        $relationKeys = [];
        foreach ($relations as $relation) {
            $relationKeys[] = $this->makeRelationKey($relation);
        }
        
        $this->relations = array_combine($relationKeys, $relations);

        $this->options = array_merge([$default, ''], $relationKeys, [static::ALL, static::ANY, static::NONE]);

        if ($nextFilter === null) {
            $this->nextFilter = new DummyFilter();
        } else {
            $this->nextFilter = $nextFilter;
        }

        $this->id = $id;
        $this->statements = [];
        $this->classes = $classes;
        $this->data = $data;
    }

    /**
     * @param ObjectWrapperInterface $relation
     * @return string
     */
    protected function makeRelationKey(ObjectWrapperInterface $relation)
    {
        return base64_encode((string)$relation->getPrimaryKey());
    }

    /**
     * @param QueryWrapperInterface $query
     * @return QueryWrapperInterface
     * @throws \Exception if given an incompatible query type.
     */
    public function queryFilter(QueryWrapperInterface $query)
    {
        $this->canQueryFilter = true;
        if ($this->getNextFilter()->canQueryFilter === false) {
            $this->canQueryFilter = false;
        }

        if ($this->canQueryFilter === true) {
            $query = $this->getNextFilter()->queryFilter($query);
            $choice = FilterControls::getControl($this->id, "value", $this->options[0]);
            $fieldName = array_search("{$this->relationName}Id", $query->getUnqualifiedPascalCasedColumnNames());

            switch ($choice) {
                case static::ALL:
                    break;
                case static::ANY:
                    $query = $query->filterBy(
                        $fieldName, QueryWrapperInterface::CONDITION_NOT_EQUAL, null
                    );
                    break;
                case static::NONE:
                    $query = $query->filterBy(
                        $fieldName, QueryWrapperInterface::CONDITION_EQUAL, null
                    );
                    break;
                default:
                    $relation = $this->relations[$choice];
                    $query = $query->filterBy(
                        $fieldName, QueryWrapperInterface::CONDITION_EQUAL, $relation->getPrimaryKey()
                    );
                    break;
            }
        }

        return $query;
    }

    /**
     * @param RowInterface[] $rows
     * @throws Exception if try to row filter.
     * @return void
     */
    public function rowFilter(array $rows)
    {
        throw new Exception(
            "Class RelationFilter cannot filter by rows. Try moving this filter higher in the filter stack."
        );
    }
}
