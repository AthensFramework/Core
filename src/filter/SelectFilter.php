<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;
use UWDOEM\Framework\Filter\FilterControls;
use UWDOEM\Framework\FilterStatement\FilterStatementInterface;

/**
 * Class SelectFilter
 * @package UWDOEM\Framework\Filter
 */
class SelectFilter extends Filter
{

    /** @var string */
    private $default;

    /**
     * @param string                     $handle
     * @param FilterStatementInterface[] $statements
     * @param string                     $default
     * @param FilterInterface|null       $nextFilter
     */
    public function __construct($handle, array $statements, $default, FilterInterface $nextFilter = null)
    {
        $this->options = array_keys($statements);

        $selection = FilterControls::getControl($handle, "value", $default);

        $statements = [$statements[$selection]];

        parent::__construct($handle, $statements, $nextFilter);
        $this->default = $default;
    }
}
