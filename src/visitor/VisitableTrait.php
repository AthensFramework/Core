<?php

namespace Athens\Core\Visitor;

/**
 * Class VisitableTrait satisfies the VisitableInterface interface.
 *
 * See the "Visitor" pattern.
 *
 * @package Athens\Core\Visitor
 */
trait VisitableTrait
{

    /**
     * Accept a visitor, per the Visitor pattern.
     *
     * @param VisitorInterface $visitor
     * @return mixed
     */
    public function accept(VisitorInterface $visitor)
    {
        $hierarchy = array_merge([get_class($this)], array_values(class_parents($this)));

        $visitorMethods = array_map(
            function ($className) {
                if (strrpos($className, "\\") !== false) {
                    $className = substr($className, strrpos($className, "\\") + 1);
                }
                return "visit" . $className;
            },
            $hierarchy
        );

        foreach ($visitorMethods as $visitorMethod) {
            if (method_exists($visitor, $visitorMethod) === true) {
                return $visitor->$visitorMethod($this);
            }
        }

        if (method_exists($visitor, "visit") === true) {
            return $visitor->visit($this);
        }

        throw new \RuntimeException(
            "No visit method in " . get_class($visitor) . " found among " .
            implode(", ", $visitorMethods) . ", or default method ::visit."
        );
    }
}
