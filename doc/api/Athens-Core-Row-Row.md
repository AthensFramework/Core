Athens\Core\Row\Row
===============

A Table child which contains fields




* Class name: Row
* Namespace: Athens\Core\Row
* This class implements: [Athens\Core\Row\RowInterface](Athens-Core-Row-RowInterface.md)






Methods
-------


### __construct

    mixed Athens\Core\Row\Row::__construct(array<mixed,string> $classes, array<mixed,string> $data, \Athens\Core\FieldBearer\FieldBearerInterface $fieldBearer, string $onClick, boolean $highlightable)





* Visibility: **public**


#### Arguments
* $classes **array&lt;mixed,string&gt;**
* $data **array&lt;mixed,string&gt;**
* $fieldBearer **[Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)**
* $onClick **string**
* $highlightable **boolean**



### getOnClick

    string Athens\Core\Row\RowInterface::getOnClick()





* Visibility: **public**
* This method is defined by [Athens\Core\Row\RowInterface](Athens-Core-Row-RowInterface.md)




### getFieldBearer

    \Athens\Core\FieldBearer\FieldBearerInterface Athens\Core\Row\RowInterface::getFieldBearer()





* Visibility: **public**
* This method is defined by [Athens\Core\Row\RowInterface](Athens-Core-Row-RowInterface.md)




### isHighlightable

    boolean Athens\Core\Row\RowInterface::isHighlightable()





* Visibility: **public**
* This method is defined by [Athens\Core\Row\RowInterface](Athens-Core-Row-RowInterface.md)




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**



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



