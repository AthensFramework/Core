<?php

namespace UWDOEM\Framework\Visitor;


interface VisitableInterface {

    function accept(Visitor $visitor);

}