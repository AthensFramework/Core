Athens\Core\Filter\FilterBuilder
===============

Class FilterBuilder




* Class name: FilterBuilder
* Namespace: Athens\Core\Filter
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)







Methods
-------


### setType

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### setPage

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setPage(integer $page)





* Visibility: **public**


#### Arguments
* $page **integer**



### setMaxPerPage

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setMaxPerPage(integer $maxPerPage)





* Visibility: **public**


#### Arguments
* $maxPerPage **integer**



### setCondition

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setCondition(string $condition)





* Visibility: **public**


#### Arguments
* $condition **string**



### setCriterion

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setCriterion(mixed $criterion)





* Visibility: **public**


#### Arguments
* $criterion **mixed**



### setFieldName

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setFieldName(string $fieldName)





* Visibility: **public**


#### Arguments
* $fieldName **string**



### addOptions

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::addOptions(array<mixed,array> $options)





* Visibility: **public**


#### Arguments
* $options **array&lt;mixed,array&gt;**



### setDefault

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setDefault(string $default)





* Visibility: **public**


#### Arguments
* $default **string**



### setNextFilter

    \Athens\Core\Filter\FilterBuilder Athens\Core\Filter\FilterBuilder::setNextFilter(\Athens\Core\Filter\FilterInterface $nextFilter)





* Visibility: **public**


#### Arguments
* $nextFilter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### build

    mixed Athens\Core\Etc\AbstractBuilder::build()

Return the element under construction.

Returns an instance of the object type under construction.

* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### begin

    static Athens\Core\Etc\AbstractBuilder::begin()





* Visibility: **public**
* This method is **static**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### clear

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::clear()





* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### setId

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::setId(string $id)

Set the unique identifier for the element to be built.



* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $id **string**



### addClass

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::addClass(string $class)

Add a display class name to the element to be built.



* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $class **string**



### addData

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::addData(string $key, string $value)

Add a data field to the element to be built.

For example, when building a field:

FieldBuilder->begin()
    ->addData('owned-by', 'bob')
    ...
    ->build();

When written to HTML, the resulting field will have
an HTML5 data attribute like:

    <... data-owned-by='bob' .../>

* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $key **string**
* $value **string**


