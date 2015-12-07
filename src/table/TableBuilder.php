<?php

namespace UWDOEM\Framework\Table;

use UWDOEM\Framework\Etc\AbstractBuilder;
use UWDOEM\Framework\Filter\DummyFilter;
use UWDOEM\Framework\Row\RowInterface;
use UWDOEM\Framework\Filter\FilterInterface;

class TableBuilder extends AbstractBuilder
{

    /** @var string */
    protected $id;

    /** @var RowInterface[] */
    protected $rows = [];

    /** @var FilterInterface */
    protected $filter;

    /**
     * @param RowInterface[] $rows
     * @return TableBuilder
     */
    public function setRows($rows)
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
        if (isset($this->filter)) {
            $filter->combine($this->filter);
        }
        $this->filter = $filter;
        return $this;
    }

    /**
     * @return TableBuilder
     */
    public static function begin()
    {
        return new static();
    }

    public function build()
    {
        $this->validateId();

        if (!isset($this->filter)) {
            $this->filter = new DummyFilter();
        }

        return new Table($this->id, $this->rows, $this->filter);
    }
}
