<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Filter\FilterInterface;

/**
 * Class TableBuilder
 *
 * @package UWDOEM\Framework\Table
 */
class TableBuilder extends AbstractBuilder
{

    /** @var RowInterface[] */
    protected $rows = [];

    /** @var FilterInterface */
    protected $filter;

    /**
     * @param RowInterface[] $rows
     * @return TableBuilder
     */
    public function setRows(array $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    /**
     * @param FilterInterface $filter
     * @return TableBuilder
     */
    public function addFilter(FilterInterface $filter)
    {
        if ($this->filter !== null) {
            $filter->combine($this->filter);
        }
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return Table
     */
    public function build()
    {
        $this->validateId();

        if ($this->filter === null) {
            $this->filter = new DummyFilter();
        }

        return new Table($this->id, $this->classes, $this->rows, $this->filter);
    }
}
