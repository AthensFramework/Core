<?php

namespace Athens\Core\Filter;

use Athens\Core\FilterStatement\FilterStatement;
use Athens\Core\FilterStatement\SortingFilterStatement;
use Athens\Core\Filter\FilterControls;
use Athens\Core\FilterStatement\FilterStatementInterface;

/**
 * Class SelectFilter
 * @package Athens\Core\Filter
 */
class SelectFilter extends Filter
{

    /** @var string */
    private $default;

    /**
     * @param string                     $id
     * @param string[]                   $classes
     * @param array                      $data
     * @param FilterStatementInterface[] $statements
     * @param string                     $default
     * @param FilterInterface|null       $nextFilter
     */
    public function __construct(
        $id,
        array $classes,
        array $data,
        array $statements,
        $default,
        FilterInterface $nextFilter = null
    ) {
        $this->options = array_keys($statements);
        $this->default = $default;

        $selection = FilterControls::getControl($id, "value", $default);

        $statements = [$statements[$selection]];

        parent::__construct($id, $classes, $data, $statements, $nextFilter);
    }
}
