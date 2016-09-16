<?php

namespace Athens\Core\Filter;

use Exception;

use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;

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

    /** @var array */
    protected $relations = [];

    /** @var string */
    protected $relationName = '';

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param string[]             $data
     * @param ModelCriteria        $query
     * @param string               $default
     * @param FilterInterface|null $nextFilter
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        ModelCriteria $query,
        $default,
        FilterInterface $nextFilter = null
    ) {
        $this->relationName = array_slice(explode('\\', $query->getModelName()), -1)[0];

        $relations = $query->find();

        $relationNames = [];
        foreach ($relations as $relation) {
            $relationNames[] = (string)$relation;
        }
        
        $this->relations = array_combine($relationNames, iterator_to_array($relations));

        $this->options = array_merge([$default, ''], $relationNames, [static::ALL, static::ANY, static::NONE]);

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
     * @param ModelCriteria $query
     * @return ModelCriteria
     * @throws \Exception if given an incompatible query type.
     */
    public function queryFilter(ModelCriteria $query)
    {
        $query = $this->getNextFilter()->queryFilter($query);

        $this->canQueryFilter = true;

        $choice = FilterControls::getControl($this->id, "value", $this->options[0]);

        if ($this->getNextFilter()->canQueryFilter === false) {
            $this->canQueryFilter = false;
        }
        
        if ($this->canQueryFilter === true) {
            switch ($choice) {
                case static::ALL:
                    break;
                case static::ANY:
                    $filterMethod = "filterBy{$this->relationName}Id";
                    $query = $query->$filterMethod(null, Criteria::NOT_EQUAL);
                    break;
                case static::NONE:
                    $filterMethod = "filterBy{$this->relationName}Id";
                    $query = $query->$filterMethod(null);
                    break;
                default:
                    $filterMethod = "filterBy{$this->relationName}";
                    $relation = $this->relations[$choice];
                    $query = $query->$filterMethod($relation);
                    break;
            }
        }

        return $query;
    }

    /**
     * @param RowInterface[] $rows
     * @return RowInterface[]
     * @throws Exception if try to row filter.
     */
    public function rowFilter(array $rows)
    {
        throw new Exception("Class RelationFilter cannot filter by rows. Try moving this filter higher in the filter stack.");
    }
}
