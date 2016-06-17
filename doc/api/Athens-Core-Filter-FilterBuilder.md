Athens\Core\Filter\FilterBuilder
===============

Class FilterBuilder




* Class name: FilterBuilder
* Namespace: Athens\Core\Filter
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)





Properties
----------


### $type

    protected string $type





* Visibility: **protected**


### $page

    protected integer $page





* Visibility: **protected**


### $maxPerPage

    protected integer $maxPerPage





* Visibility: **protected**


### $fieldName

    protected string $fieldName





* Visibility: **protected**


### $condition

    protected string $condition





* Visibility: **protected**


### $criterion

    protected mixed $criterion





* Visibility: **protected**


### $handle

    protected string $handle





* Visibility: **protected**


### $nextFilter

    protected \Athens\Core\Filter\FilterInterface $nextFilter





* Visibility: **protected**


### $options

    protected array<mixed,array> $options





* Visibility: **protected**


### $default

    protected string $default





* Visibility: **protected**


### $criterionHasBeenSet

    protected boolean $criterionHasBeenSet = false

null is an acceptable value for criterion, so we use this flag to know
whether or not criterion has been set.



* Visibility: **protected**


### $id

    protected string $id





* Visibility: **protected**


### $classes

    protected array<mixed,string> $classes = array()





* Visibility: **protected**


### $data

    protected array<mixed,string> $data = array()





* Visibility: **protected**


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



### retrieveOrException

    mixed Athens\Core\Filter\FilterBuilder::retrieveOrException(string $attrName, string $methodName, string $reason)

If it has been set, retrieve the indicated property from this builder. If not, throw exception.



* Visibility: **protected**


#### Arguments
* $attrName **string** - &lt;p&gt;The name of the attribute to retrieve, including underscore.&lt;/p&gt;
* $methodName **string** - &lt;p&gt;The name of the calling method, optional.&lt;/p&gt;
* $reason **string** - &lt;p&gt;An optional, additional &quot;reason&quot; to display with the exception.&lt;/p&gt;



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



### validateId

    void Athens\Core\Etc\AbstractBuilder::validateId()

Assert that a unique identifier has been provided for the element to be built.



* Visibility: **protected**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)



