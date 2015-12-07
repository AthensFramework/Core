<?php

namespace UWDOEM\Framework\Filter;

use UWDOEM\Framework\FilterStatement\FilterStatement;
use UWDOEM\Framework\FilterStatement\SortingFilterStatement;
use UWDOEM\Framework\Filter\FilterControls;

class SelectFilter extends Filter
{

    /**
     * @var null|FilterInterface
     */
    private $default;

    public function __construct($handle, array $statements, $default, FilterInterface $nextFilter = null)
    {

        $this->options = array_keys($statements);

        $selection = FilterControls::getControl($handle, "value", $default);

        $statements = [$statements[$selection]];

        parent::__construct($handle, $statements, $nextFilter);
        $this->default = $default;
    }
}
