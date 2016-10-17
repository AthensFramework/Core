<?php

namespace Athens\Core\ORMWrapper;

/**
 * Class AbstractQueryWrapper
 *
 * @package Athens\Core\ORMWrapper
 */
abstract class AbstractQueryWrapper extends AbstractORMWrapper implements QueryWrapperInterface
{

    /**
     * @param mixed $query
     * @return QueryWrapperInterface
     */
    public static function fromQuery($query)
    {
        return new static($query);
    }
}
