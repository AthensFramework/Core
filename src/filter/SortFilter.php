<?php

namespace Athens\Core\Filter;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;
use Athens\Core\ORMWrapper\QueryWrapperInterface;

/**
 * Class SortFilter
 * @package Athens\Core\Filter
 */
class SortFilter extends Filter
{

    /**
     * @param string               $id
     * @param string[]             $classes
     * @param array                $data
     * @param FilterInterface|null $nextFilter
     */
    public function __construct($id, array $classes, array $data, FilterInterface $nextFilter = null)
    {

        $statements = [];
        if (FilterControls::controlIsSet($id, "fieldname") === true) {
            $fieldName = FilterControls::getControl($id, "fieldname");
            $order = FilterControls::getControl($id, "order", FilterStatement::COND_SORT_ASC);

            $statements[] = new SortingFilterStatement($fieldName, $order, null, null);
        }

        parent::__construct($id, $classes, $data, $statements, $nextFilter);
    }


//    Joe start here

    public function queryFilter(QueryWrapperInterface $query)
    {
        $this->canQueryFilter = true;
        if ($this->getNextFilter()->canQueryFilter === false) {
            $this->canQueryFilter = false;
        }

        $statement = $this->statements[0];

        $fieldName = $statement->getFieldName();
        $condition = $statement->getCondition();

        



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


//    Joe end here
}
