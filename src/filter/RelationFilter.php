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

    protected $default;

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

        $relationNames = [];
        foreach ($relations as $relation) {
            $relationNames[] = (string)$relation;
        }
        
        $this->relations = array_combine($relationNames, iterator_to_array($relations));

        $relationOptions = array_combine($relationKeys, $relationNames);

        $this->options = array_merge([$default, ''], $relationOptions, [static::ALL, static::ANY, static::NONE]);

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
            $choiceKey = FilterControls::getControl($this->id, "value", array_keys($this->options)[0]);
            $choice = $this->options[$choiceKey];
            $fieldName = array_search("{$this->relationName}Id", $query->getUnqualifiedPascalCasedColumnNames());

            switch ($choice) {
                case static::ALL:
                    break;
                case static::ANY:
                    $query = $query->filterBy(
                        $fieldName,
                        null,
                        QueryWrapperInterface::CONDITION_NOT_EQUAL
                    );
                    break;
                case static::NONE:
                    $query = $query->filterBy(
                        $fieldName,
                        null,
                        QueryWrapperInterface::CONDITION_EQUAL
                    );
                    break;
                default:
                    $relation = $this->relations[$choice];
                    $query = $query->filterBy(
                        $fieldName,
                        $relation->getPrimaryKey(),
                        QueryWrapperInterface::CONDITION_EQUAL
                    );
                    break;
            }
        }

        return $query;
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     */
    public function rowFilter(array $rows)
    {
        return $rows;
    }
}
