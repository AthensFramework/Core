Athens\Core\Table\Table
===============

Class Table




* Class name: Table
* Namespace: Athens\Core\Table
* This class implements: [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)






Methods
-------


### __construct

    mixed Athens\Core\Table\Table::__construct(string $id, array<mixed,string> $classes, array $data, array $rows, \Athens\Core\Filter\FilterInterface $filter)





* Visibility: **public**


#### Arguments
* $id **string**
* $classes **array&lt;mixed,string&gt;**
* $data **array**
* $rows **array**
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### getRows

    array<mixed,\Athens\Core\Row\RowInterface> Athens\Core\Table\TableInterface::getRows()





* Visibility: **public**
* This method is defined by [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)




### getFilter

    \Athens\Core\Filter\FilterInterface Athens\Core\Table\TableInterface::getFilter()





* Visibility: **public**
* This method is defined by [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)




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



