<?php

namespace UWDOEM\Framework\Visitor;

interface VisitableInterface
{

    public function accept(Visitor $visitor);
}
