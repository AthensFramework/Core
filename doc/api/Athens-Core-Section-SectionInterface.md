Athens\Core\Section\SectionInterface
===============






* Interface name: SectionInterface
* Namespace: Athens\Core\Section
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md), [Athens\Core\Initializer\InitializableInterface](Athens-Core-Initializer-InitializableInterface.md)





Methods
-------


### getType

    string Athens\Core\Section\SectionInterface::getType()





* Visibility: **public**




### getWritables

    array<mixed,\Athens\Core\Section\SectionInterface> Athens\Core\Section\SectionInterface::getWritables()





* Visibility: **public**




### getId

    string Athens\Core\Writer\WritableInterface::getId()

Return a unique identifier that will be consistent between requests.



* Visibility: **public**
* This method is defined by [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)




### getClasses

    array<mixed,string> Athens\Core\Writer\WritableInterface::getClasses()





* Visibility: **public**
* This method is defined by [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)




### getData

    array<mixed,string> Athens\Core\Writer\WritableInterface::getData()





* Visibility: **public**
* This method is defined by [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**


