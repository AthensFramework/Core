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

    /** @var string */
    protected $relationNamePlural = '';

    /**
     * @param string                $id
     * @param string[]              $classes
     * @param string[]              $data
     * @param QueryWrapperInterface $query
     * @param mixed                 $default
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

        $this->relationNamePlural .= substr($this->relationName, -1) === 's' ?  'es' : 's';

        $relations = $query->find();

        $relationOptions = [];
        foreach ($relations as $relation) {
            $key = $this->makeRelationKey($relation);
            $relationName = (string)$relation;

            $this->relations[$key] = $relation;
            $relationOptions[$key] = $relationName;
        }

        if ($default === static::ALL) {
            $default = $this->getAllText();
        } elseif ($default === static::ANY) {
            $default = $this->getAnyText();
        } elseif ($default === static::NONE) {
            $default = $this->getNoneText();
        }

        $this->options = array_merge(
            [$default, ''],
            $relationOptions,
            [$this->getAllText(), $this->getAnyText(), $this->getNoneText()]
        );

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
     * @return string
     */
    public function getAllText()
    {
        return "All ({$this->relationNamePlural})";
    }

    /**
     * @return string
     */
    public function getAnyText()
    {
        return "Having Any {$this->relationName}";
    }

    /**
     * @return string
     */
    public function getNoneText()
    {
        return "Having No {$this->relationName}";
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
                case $this->getAllText():
                    break;
                case $this->getAnyText():
                    $query = $query->filterBy(
                        $fieldName,
                        null,
                        QueryWrapperInterface::CONDITION_NOT_EQUAL
                    );
                    break;
                case $this->getNoneText():
                    $query = $query->filterBy(
                        $fieldName,
                        null,
                        QueryWrapperInterface::CONDITION_EQUAL
                    );
                    break;
                default:
                    $relation = $choice;
                    if (is_string($relation) === true) {
                        $relation = $this->relations[array_search($relation, $this->options)];
                    }

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
