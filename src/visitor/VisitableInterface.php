<?php

namespace Athens\Core\Visitor;

interface VisitableInterface
{

    /**
     * Accept a visitor, per the Visitor pattern.
     *
     * @param Visitor $visitor
     * @return mixed
     */
    public function accept(Visitor $visitor);
}
