<?php

namespace Athens\Core\Filter;

use Propel\Runtime\ActiveQuery\ModelCriteria;

use Athens\Core\Etc\ORMUtils;
use Athens\Core\Filter\SelectFilter;
use Athens\Core\Filter\FilterInterface;
use Athens\Core\Filter\FilterControls;
use Athens\Core\Visitor\Visitor;
use Athens\Core\Filter\DummyFilter;
use Athens\Core\Row\RowInterface;

use Forms\FormQuery;

class RelationFilter extends SelectFilter
{

    const ALL = 'All';
    
    protected $relations = [];
    protected $relationName = '';

    /**
     * @param string                     $id
     * @param string[]                   $classes
     * @param string[]                   $data
     * @param ModelCriteria              $query
     * @param string                     $default
     * @param FilterInterface|null       $nextFilter
     */
    public function __construct($id, array $classes, array $data, ModelCriteria $query, $default, FilterInterface $nextFilter = null)
    {
        $this->relationName = array_slice(explode('\\', $query->getModelName()), -1)[0];

        $relations = $query->find();

        $relationNames = [];
        foreach ($relations as $relation) {
            $relationNames[] = (string)$relation;
        }
        
        $this->relations = array_combine($relationNames, iterator_to_array($relations));

        $this->options = array_merge([$default, ''], $relationNames, [static::ALL]);

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
     * @throws \Exception if given an incompatible query type
     */
    public function queryFilter(ModelCriteria $query)
    {
        $query = $this->getNextFilter()->queryFilter($query);

        $this->canQueryFilter = true;

        $choice = FilterControls::getControl($this->id, "value", $this->options[0]);

        if ($this->getNextFilter()->canQueryFilter === false) {
            $this->canQueryFilter = false;
        }
        
        if ($this->canQueryFilter === true  && $choice !== static::ALL) {
            $filterMethod = "filterBy{$this->relationName}";
            $relation = $this->relations[$choice];

            $query = $query->$filterMethod($relation);
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