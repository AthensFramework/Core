<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\Etc\Settings;


class FilterBuilder {

    /** @var string */
    protected $_type;

    /** @var int */
    protected $_paginateBy;

    /** @var string */
    protected $_fieldName;

    /** @var string */
    protected $_condition;

    /** @var mixed */
    protected $_criterion;

    /** @var string */
    protected $_handle;


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
     * @param int $paginateBy
     * @return FilterBuilder
     */
    public function setPaginateBy($paginateBy) {
        $this->_paginateBy = $paginateBy;
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
                $criterion = $this->retrieveOrException("_criterion", __METHOD__);

                $statements[] = new FilterStatement($fieldName, $condition, $criterion);

                break;
            case Filter::TYPE_PAGINATION:

                $paginateBy = isset($this->_paginateBy) ? $this->_paginateBy : Settings::getDefaultPagination();

                $statements[] = new FilterStatement(null, FilterStatement::COND_PAGINATE_BY, $paginateBy);

                break;
        }

        if (empty($statements)) {
            throw new \Exception("Invalid filter type.");
        }

        return new Filter($handle, $type, $statements);
    }



}