Athens\Core\FilterStatement\SortingFilterStatement
===============

Class SortingFilterStatement




* Class name: SortingFilterStatement
* Namespace: Athens\Core\FilterStatement
* Parent class: [Athens\Core\FilterStatement\FilterStatement](Athens-Core-FilterStatement-FilterStatement.md)





Properties
----------


### $fieldName

    protected string $fieldName





* Visibility: **protected**


### $condition

    protected string $condition





* Visibility: **protected**


### $criterion

    protected mixed $criterion





* Visibility: **protected**


### $control

    protected mixed $control





* Visibility: **protected**


Methods
-------


### applyToQuery

    \Propel\Runtime\ActiveQuery\ModelCriteria Athens\Core\FilterStatement\FilterStatementInterface::applyToQuery(\Propel\Runtime\ActiveQuery\ModelCriteria $query)





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**



### applyToRows

    array<mixed,\Athens\Core\Row\RowInterface> Athens\Core\FilterStatement\FilterStatementInterface::applyToRows(array<mixed,\Athens\Core\Row\RowInterface> $rows)





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)


#### Arguments
* $rows **array&lt;mixed,\Athens\Core\Row\RowInterface&gt;**



### __construct

    mixed Athens\Core\FilterStatement\FilterStatement::__construct(string $fieldName, string $condition, mixed $criterion, mixed $control)

FilterStatement constructor.



* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatement](Athens-Core-FilterStatement-FilterStatement.md)


#### Arguments
* $fieldName **string**
* $condition **string**
* $criterion **mixed**
* $control **mixed**



### getFieldName

    string Athens\Core\FilterStatement\FilterStatementInterface::getFieldName()





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)




### getCondition

    string Athens\Core\FilterStatement\FilterStatementInterface::getCondition()





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)




### getCriterion

    mixed Athens\Core\FilterStatement\FilterStatementInterface::getCriterion()





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)




### getControl

    mixed Athens\Core\FilterStatement\FilterStatementInterface::getControl()





* Visibility: **public**
* This method is defined by [Athens\Core\FilterStatement\FilterStatementInterface](Athens-Core-FilterStatement-FilterStatementInterface.md)



