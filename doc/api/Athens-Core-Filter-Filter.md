Athens\Core\Filter\Filter
===============

Class Filter




* Class name: Filter
* Namespace: Athens\Core\Filter
* This class implements: [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)


Constants
----------


### TYPE_SEARCH

    const TYPE_SEARCH = "search"





### TYPE_SORT

    const TYPE_SORT = "sort"





### TYPE_SELECT

    const TYPE_SELECT = "select"





### TYPE_STATIC

    const TYPE_STATIC = "static"





### TYPE_PAGINATION

    const TYPE_PAGINATION = "pagination"







Methods
-------


### __construct

    mixed Athens\Core\Filter\Filter::__construct(string $id, array<mixed,string> $classes, array $data, array<mixed,\Athens\Core\FilterStatement\FilterStatementInterface> $statements, \Athens\Core\Filter\FilterInterface|null $nextFilter)





* Visibility: **public**


#### Arguments
* $id **string**
* $classes **array&lt;mixed,string&gt;**
* $data **array**
* $statements **array&lt;mixed,\Athens\Core\FilterStatement\FilterStatementInterface&gt;**
* $nextFilter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)|null**



### getFeedback

    array<mixed,string> Athens\Core\Filter\FilterInterface::getFeedback()





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)




### combine

    void Athens\Core\Filter\FilterInterface::combine(\Athens\Core\Filter\FilterInterface $filter)





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### getNextFilter

    \Athens\Core\Filter\FilterInterface Athens\Core\Filter\FilterInterface::getNextFilter()





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)




### getStatements

    array<mixed,\Athens\Core\FilterStatement\FilterStatementInterface> Athens\Core\Filter\FilterInterface::getStatements()





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)




### queryFilter

    \Propel\Runtime\ActiveQuery\ModelCriteria Athens\Core\Filter\FilterInterface::queryFilter(\Propel\Runtime\ActiveQuery\ModelCriteria $query)





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**



### rowFilter

    array<mixed,\Athens\Core\Row\Row> Athens\Core\Filter\FilterInterface::rowFilter(array<mixed,\Athens\Core\Row\Row> $rows)





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)


#### Arguments
* $rows **array&lt;mixed,\Athens\Core\Row\Row&gt;**



### getOptions

    array Athens\Core\Filter\FilterInterface::getOptions()





* Visibility: **public**
* This method is defined by [Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)




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



