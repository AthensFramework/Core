<?php

namespace Athens\Core\Visitor;

interface VisitableInterface
{

    /**
     * Accept a visitor, per the Visitor pattern.
     *
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor);
}
