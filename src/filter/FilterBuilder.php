<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\FilterStatementInterface;
use UWDOEM\Framework\FilterStatement\ExcludingFilterStatement;
use UWDOEM\Framework\FilterStatement\PaginationFilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;


class FilterBuilder {

    /** @var string */
    protected $_type;

    /** @var int */
    protected $_page;

    /** @var int */
    protected $_maxPerPage;

    /** @var string */
    protected $_fieldName;

    /** @var string */
    protected $_condition;

    /** @var mixed */
    protected $_criterion;

    /** @var string */
    protected $_handle;

    /** @var FilterInterface */
    protected $_nextFilter;


    protected function __construct() {}

    public static function begin() {
        return new static();
    }

    /**
     * @param string $type
     * @return FilterBuilder
     */
    public function setType($type) {
        $this->_type = $type;
        return $this;
    }

    /**
     * @param int $page
     * @return FilterBuilder
     */
    public function setPage($page) {
        $this->_page = $page;
        return $this;
    }

    /**
     * @param int $maxPerPage
     * @return FilterBuilder
     */
    public function setMaxPerPage($maxPerPage) {
        $this->_maxPerPage = $maxPerPage;
        return $this;
    }

    /**
     * @param string $condition
     * @return FilterBuilder
     */
    public function setCondition($condition) {
        $this->_condition = $condition;
        return $this;
    }

    /**
     * @param mixed $criterion
     * @return FilterBuilder
     */
    public function setCriterion($criterion) {
        $this->_criterion = $criterion;
        return $this;
    }

    /**
     * @param string $name
     * @return FilterBuilder
     */
    public function setHandle($name) {
        $this->_handle = $name;
        return $this;
    }

    /**
     * @param string $fieldName
     * @return FilterBuilder
     */
    public function setFieldName($fieldName) {
        $this->_fieldName = $fieldName;
        return $this;
    }

    /**
     * If it has been set, retrieve the indicated property from this builder. If not, throw exception.
     *
     * @param string $attrName The name of the attribute to retrieve, including underscore.
     * @param string $methodName The name of the calling method, optional.
     * @param string $reason An optional, additional "reason" to display with the exception.
     * @return mixed The indicated attribute, if set.
     * @throws \Exception if the indicated attribute has not been set, or if the attribute does not exist
     */
    protected function retrieveOrException($attrName, $methodName = "this method", $reason = "") {

        if (!property_exists($this, $attrName)) {
            throw new \Exception("Property $attrName not found in class.");
        }

        if (!isset($this->$attrName)) {
            $message = $reason ? "Becase you $reason, " : "You ";
            $message .= "must set $attrName for this object before calling $methodName.";

            throw new \Exception($message);
        }

        return $this->$attrName;
    }

    /**
     * @param FilterInterface $nextFilter
     * @return FilterBuilder
     */
    public function setNextFilter($nextFilter) {
        $this->_nextFilter = $nextFilter;
        return $this;
    }



    /**
     * @return FilterInterface
     * @throws \Exception if an appropriate combination of fields have not been set.
     */
    public function build() {

        $handle = $this->retrieveOrException("_handle", __METHOD__);
        $type = $this->retrieveOrException("_type", __METHOD__);

        $statements = [];
        switch ($type) {
            case Filter::TYPE_STATIC:

                $fieldName = $this->retrieveOrException("_fieldName", __METHOD__);
                $condition = $this->retrieveOrException("_condition", __METHOD__);

                if (in_array(
                    $condition,
                    [FilterStatementInterface::COND_SORT_ASC, FilterStatementInterface::COND_SORT_DESC])
                ) {
                    $criterion = $this->_criterion;
                    $statements[] = new SortingFilterStatement($fieldName, $condition, $criterion, null);
                } else {
                    $criterion = $this->retrieveOrException("_criterion", __METHOD__);
                    $statements[] = new ExcludingFilterStatement($fieldName, $condition, $criterion, null);
                }

                return new Filter($handle, $statements, $this->_nextFilter);

                break;
            case Filter::TYPE_PAGINATION:
                $maxPerPage = isset($this->_maxPerPage) ? $this->_maxPerPage : Settings::getDefaultPagination();
                $page = isset($this->_page) ? $this->_page : FilterControls::getControl($handle, "page", 1);

                return new PaginationFilter($handle, $maxPerPage, $page, $this->_nextFilter);

                break;
            case Filter::TYPE_SORT:
                return new SortFilter($handle, $this->_nextFilter);

                break;
            case Filter::TYPE_SEARCH:
                return new SearchFilter($handle, $this->_nextFilter);
                break;
            default:
                throw new \Exception("Invalid filter type.");
        }
    }
}