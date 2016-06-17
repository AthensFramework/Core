Athens\Core\Filter\FilterInterface
===============






* Interface name: FilterInterface
* Namespace: Athens\Core\Filter
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)





Methods
-------


### combine

    void Athens\Core\Filter\FilterInterface::combine(\Athens\Core\Filter\FilterInterface $filter)





* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### getFeedback

    array<mixed,string> Athens\Core\Filter\FilterInterface::getFeedback()





* Visibility: **public**




### getNextFilter

    \Athens\Core\Filter\FilterInterface Athens\Core\Filter\FilterInterface::getNextFilter()





* Visibility: **public**




### getStatements

    array<mixed,\Athens\Core\FilterStatement\FilterStatementInterface> Athens\Core\Filter\FilterInterface::getStatements()





* Visibility: **public**




### getOptions

    array Athens\Core\Filter\FilterInterface::getOptions()





* Visibility: **public**




### queryFilter

    \Propel\Runtime\ActiveQuery\ModelCriteria Athens\Core\Filter\FilterInterface::queryFilter(\Propel\Runtime\ActiveQuery\ModelCriteria $query)





* Visibility: **public**


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**



### rowFilter

    array<mixed,\Athens\Core\Row\Row> Athens\Core\Filter\FilterInterface::rowFilter(array<mixed,\Athens\Core\Row\Row> $rows)





* Visibility: **public**


#### Arguments
* $rows **array&lt;mixed,\Athens\Core\Row\Row&gt;**



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


