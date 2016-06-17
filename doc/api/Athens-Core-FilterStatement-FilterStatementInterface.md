Athens\Core\FilterStatement\FilterStatementInterface
===============






* Interface name: FilterStatementInterface
* Namespace: Athens\Core\FilterStatement
* This is an **interface**


Constants
----------


### COND_SORT_ASC

    const COND_SORT_ASC = "ascending"





### COND_SORT_DESC

    const COND_SORT_DESC = "descending"





### COND_LESS_THAN

    const COND_LESS_THAN = "LESS THAN"





### COND_GREATER_THAN

    const COND_GREATER_THAN = "GREATER THAN"





### COND_EQUAL_TO

    const COND_EQUAL_TO = "EQUAL TO"





### COND_NOT_EQUAL_TO

    const COND_NOT_EQUAL_TO = "NOT EQUAL TO"





### COND_CONTAINS

    const COND_CONTAINS = "CONTAINS"





### COND_ALL

    const COND_ALL = "ALL"





### COND_PAGINATE_BY

    const COND_PAGINATE_BY = 8







Methods
-------


### getFieldName

    string Athens\Core\FilterStatement\FilterStatementInterface::getFieldName()





* Visibility: **public**




### getCondition

    string Athens\Core\FilterStatement\FilterStatementInterface::getCondition()





* Visibility: **public**




### getCriterion

    mixed Athens\Core\FilterStatement\FilterStatementInterface::getCriterion()





* Visibility: **public**




### getControl

    mixed Athens\Core\FilterStatement\FilterStatementInterface::getControl()





* Visibility: **public**




### applyToQuery

    \Propel\Runtime\ActiveQuery\ModelCriteria Athens\Core\FilterStatement\FilterStatementInterface::applyToQuery(\Propel\Runtime\ActiveQuery\ModelCriteria $query)





* Visibility: **public**


#### Arguments
* $query **Propel\Runtime\ActiveQuery\ModelCriteria**



### applyToRows

    array<mixed,\Athens\Core\Row\RowInterface> Athens\Core\FilterStatement\FilterStatementInterface::applyToRows(array<mixed,\Athens\Core\Row\RowInterface> $rows)





* Visibility: **public**


#### Arguments
* $rows **array&lt;mixed,\Athens\Core\Row\RowInterface&gt;**


