<?php

namespace Athens\Core\Filter;

use Athens\Core\ORMWrapper\QueryWrapperInterface;

use Athens\Core\Writable\AbstractWritableBuilder;
use Athens\Core\Settings\Settings;
use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\FilterStatementInterface;
use Athens\Core\FilterStatement\ExcludingFilterStatement;
use Athens\Core\FilterStatement\PaginationFilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;

/**
 * Class FilterBuilder
 *
 * @package Athens\Core\Filter
 */
class FilterBuilder extends AbstractWritableBuilder
{

    /** @var string */
    protected $type;

    /** @var int */
    protected $page;

    /** @var int */
    protected $maxPerPage;

    /** @var string */
    protected $fieldName;

    /** @var string */
    protected $condition;

    /** @var mixed */
    protected $criterion;

    /** @var string */
    protected $handle;

    /** @var FilterInterface */
    protected $nextFilter;

    /** @var array[] */
    protected $options;

    /** @var string */
    protected $default;
    
    /** @var QueryWrapperInterface */
    protected $query;
    
    /**
     * null is an acceptable value for criterion, so we use this flag to know
     * whether or not criterion has been set.
     * @var boolean
     */
    protected $criterionHasBeenSet = false;

     /**
     * @param string $type
     * @return FilterBuilder
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @param integer $page
     * @return FilterBuilder
     */
    public function setPage($page)
    {
        $this->page = $page;
        return $this;
    }

    /**
     * @param integer $maxPerPage
     * @return FilterBuilder
     */
    public function setMaxPerPage($maxPerPage)
    {
        $this->maxPerPage = $maxPerPage;
        return $this;
    }

    /**
     * @param string $condition
     * @return FilterBuilder
     */
    public function setCondition($condition)
    {
        $this->condition = $condition;
        return $this;
    }

    /**
     * @param mixed $criterion
     * @return FilterBuilder
     */
    public function setCriterion($criterion)
    {
        $this->criterionHasBeenSet = true;
        $this->criterion = $criterion;
        return $this;
    }

    /**
     * @param string $fieldName
     * @return FilterBuilder
     */
    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
        return $this;
    }

    /**
     * @param array[] $options
     * @return FilterBuilder
     */
    public function addOptions(array $options)
    {
        if ($this->options === null) {
            $this->options = [];
        }

        $this->options = array_merge($this->options, $options);
        return $this;
    }

    /**
     * @param string $default
     * @return FilterBuilder
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * If it has been set, retrieve the indicated property from this builder. If not, throw exception.
     *
     * @param string $attrName   The name of the attribute to retrieve, including underscore.
     * @param string $methodName The name of the calling method, optional.
     * @param string $reason     An optional, additional "reason" to display with the exception.
     * @return mixed The indicated attribute, if set.
     * @throws \Exception If the indicated attribute has not been set, or if the attribute does not exist.
     */
    protected function retrieveOrException($attrName, $methodName = "this method", $reason = "")
    {

        if (property_exists($this, $attrName) === false) {
            throw new \Exception("Property $attrName not found in class.");
        }

        if ($this->$attrName === null) {
            $message = $reason !== "" ? "Because you $reason, " : "You ";
            $message .= "must set $attrName for this object before calling $methodName.";

            throw new \Exception($message);
        }

        return $this->$attrName;
    }

    /**
     * @param mixed $query
     * @return FilterBuilder
     */
    public function setQuery($query)
    {
        $this->query = $this->wrapQuery($query);
        return $this;
    }

    /**
     * @param FilterInterface $nextFilter
     * @return FilterBuilder
     */
    public function setNextFilter(FilterInterface $nextFilter)
    {
        $this->nextFilter = $nextFilter;
        return $this;
    }

    /**
     * @return FilterInterface
     * @throws \Exception If an appropriate combination of fields have not been set.
     */
    public function build()
    {
        $this->validateId();

        $type = $this->retrieveOrException("type", __METHOD__);

        $statements = [];
        switch ($type) {
            case Filter::TYPE_STATIC:
                $fieldName = $this->retrieveOrException("fieldName", __METHOD__);
                $condition = $this->retrieveOrException("condition", __METHOD__);

                if (in_array(
                    $condition,
                    [FilterStatementInterface::COND_SORT_ASC, FilterStatementInterface::COND_SORT_DESC]
                ) === true
                ) {
                    $criterion = $this->criterion;
                    $statements[] = new SortingFilterStatement($fieldName, $condition, $criterion, null);
                } else {
                    $criterion = $this->criterionHasBeenSet === true ?
                        $this->criterion :
                        $this->retrieveOrException("criterion", __METHOD__);

                    $statements[] = new ExcludingFilterStatement($fieldName, $condition, $criterion, null);
                }

                return new Filter($this->id, $this->classes, $this->data, $statements, $this->nextFilter);

                break;
            case Filter::TYPE_PAGINATION:
                $maxPerPage = $this->maxPerPage === null ?
                    Settings::getInstance()->getDefaultPagination(): $this->maxPerPage;
                
                $page = $this->page === null ? FilterControls::getControl($this->id, "page", 1) : $this->page;

                return new PaginationFilter($this->id, $this->classes, $maxPerPage, $page, $this->nextFilter);

                break;
            case Filter::TYPE_SORT:
                return new SortFilter($this->id, $this->classes, $this->data, $this->nextFilter);

                break;
            case Filter::TYPE_SEARCH:
                return new SearchFilter($this->id, $this->classes, $this->data, $this->nextFilter);
                break;
            case Filter::TYPE_SELECT:
                $options = $this->retrieveOrException("options", __METHOD__, "chose to create a select filter");
                $default = $this->retrieveOrException("default", __METHOD__, "chose to create a select filter");

                if (array_key_exists($default, $options) === false) {
                    $optionsText = implode(", ", array_keys($options));
                    throw new \Exception(
                        "For select filter '{$this->id}', your default choice " .
                        "'$default' must be among options '$optionsText'."
                    );
                }
                
                $options = array_merge([" " . $default => $options[$default], " " => $options[$default]], $options);

                $statements = array_map(
                    function ($option) {
                        return new ExcludingFilterStatement($option[0], $option[1], $option[2], null);
                    },
                    $options
                );

                return new SelectFilter(
                    $this->id,
                    $this->classes,
                    $this->data,
                    $statements,
                    $default,
                    $this->nextFilter
                );
                break;
            case Filter::TYPE_RELATION:
                $query = $this->retrieveOrException("query", __METHOD__, "chose to create a relation filter");
                $default = $this->retrieveOrException("default", __METHOD__, "chose to create a relation filter");

                return new RelationFilter(
                    $this->id,
                    $this->classes,
                    $this->data,
                    $query,
                    $default,
                    $this->nextFilter
                );
                break;
            default:
                throw new \Exception("Invalid filter type.");
        }
    }
}
