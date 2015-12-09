<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\FilterStatementInterface;
use UWDOEM\Framework\FilterStatement\ExcludingFilterStatement;
use UWDOEM\Framework\FilterStatement\PaginationFilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;

class FilterBuilder extends AbstractBuilder
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
        $this->criterion = $criterion;
        return $this;
    }

    /**
     * @param string $name
     * @return FilterBuilder
     */
    public function setHandle($name)
    {
        $this->handle = $name;
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
    public function addOptions($options)
    {
        if (!isset($this->options)) {
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
     * @throws \Exception if the indicated attribute has not been set, or if the attribute does not exist
     */
    protected function retrieveOrException($attrName, $methodName = "this method", $reason = "")
    {

        if (!property_exists($this, $attrName)) {
            throw new \Exception("Property $attrName not found in class.");
        }

        if (!isset($this->$attrName)) {
            $message = $reason ? "Because you $reason, " : "You ";
            $message .= "must set $attrName for this object before calling $methodName.";

            throw new \Exception($message);
        }

        return $this->$attrName;
    }

    /**
     * @param FilterInterface $nextFilter
     * @return FilterBuilder
     */
    public function setNextFilter($nextFilter)
    {
        $this->nextFilter = $nextFilter;
        return $this;
    }



    /**
     * @return FilterInterface
     * @throws \Exception if an appropriate combination of fields have not been set.
     */
    public function build()
    {

        $handle = $this->retrieveOrException("handle", __METHOD__);
        $type = $this->retrieveOrException("type", __METHOD__);

        $statements = [];
        switch ($type) {
            case Filter::TYPE_STATIC:
                $fieldName = $this->retrieveOrException("fieldName", __METHOD__);
                $condition = $this->retrieveOrException("condition", __METHOD__);

                if (in_array(
                    $condition,
                    [FilterStatementInterface::COND_SORT_ASC, FilterStatementInterface::COND_SORT_DESC]
                )
                ) {
                    $criterion = $this->criterion;
                    $statements[] = new SortingFilterStatement($fieldName, $condition, $criterion, null);
                } else {
                    $criterion = $this->retrieveOrException("criterion", __METHOD__);
                    $statements[] = new ExcludingFilterStatement($fieldName, $condition, $criterion, null);
                }

                return new Filter($handle, $statements, $this->nextFilter);

                break;
            case Filter::TYPE_PAGINATION:
                $maxPerPage = isset($this->maxPerPage) ? $this->maxPerPage : Settings::getDefaultPagination();
                $page = isset($this->page) ? $this->page : FilterControls::getControl($handle, "page", 1);

                return new PaginationFilter($handle, $maxPerPage, $page, $this->nextFilter);

                break;
            case Filter::TYPE_SORT:
                return new SortFilter($handle, $this->nextFilter);

                break;
            case Filter::TYPE_SEARCH:
                return new SearchFilter($handle, $this->nextFilter);
                break;
            case Filter::TYPE_SELECT:
                $options = $this->retrieveOrException("options", __METHOD__, "chose to create a select filter");
                $default = $this->retrieveOrException("default", __METHOD__, "chose to create a select filter");

                if (!array_key_exists($default, $options)) {
                    $optionsText = implode(", ", array_keys($options));
                    throw new \Exception(
                        "For select filter '$handle', your default choice " .
                        "'$default' must be among options '$optionsText'."
                    );
                }

                $statements = array_map(
                    function ($option) {
                        return new ExcludingFilterStatement($option[0], $option[1], $option[2], null);
                    },
                    $options
                );

                return new SelectFilter($handle, $statements, $default, $this->nextFilter);
                break;
            default:
                throw new \Exception("Invalid filter type.");
        }
    }
}
