Athens\Core\Row\RowBuilder
===============

Class RowBuilder




* Class name: RowBuilder
* Namespace: Athens\Core\Row
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)





Properties
----------


### $onClick

    protected string $onClick





* Visibility: **protected**


### $highlightable

    protected boolean $highlightable = false





* Visibility: **protected**


### $fieldBearerBuilder

    private \Athens\Core\FieldBearer\FieldBearerBuilder $fieldBearerBuilder





* Visibility: **private**


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


### setOnClick

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setOnClick(string $onClick)





* Visibility: **public**


#### Arguments
* $onClick **string**



### setHighlightable

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setHighlightable(boolean $highlightable)





* Visibility: **public**


#### Arguments
* $highlightable **boolean**



### begin

    static Athens\Core\Etc\AbstractBuilder::begin()





* Visibility: **public**
* This method is **static**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### build

    mixed Athens\Core\Etc\AbstractBuilder::build()

Return the element under construction.

Returns an instance of the object type under construction.

* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### createFieldBearerBuilderIfNull

    void Athens\Core\Row\RowBuilder::createFieldBearerBuilderIfNull()





* Visibility: **private**




### getFieldBearerBuilder

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\Row\RowBuilder::getFieldBearerBuilder()





* Visibility: **private**




### buildFieldBearer

    \Athens\Core\FieldBearer\FieldBearer Athens\Core\Row\RowBuilder::buildFieldBearer()





* Visibility: **protected**




### addFieldBearers

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::addFieldBearers(array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> $fieldBearers)





* Visibility: **public**


#### Arguments
* $fieldBearers **array&lt;mixed,\Athens\Core\FieldBearer\FieldBearerInterface&gt;**



### addFields

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::addFields(array<mixed,\Athens\Core\Field\FieldInterface> $fields)





* Visibility: **public**


#### Arguments
* $fields **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**



### addObject

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::addObject(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object)





* Visibility: **public**


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**



### setVisibleFieldNames

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setVisibleFieldNames(array<mixed,string> $visibleFieldNames)





* Visibility: **public**


#### Arguments
* $visibleFieldNames **array&lt;mixed,string&gt;**



### setHiddenFieldNames

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setHiddenFieldNames(array<mixed,string> $hiddenFieldNames)





* Visibility: **public**


#### Arguments
* $hiddenFieldNames **array&lt;mixed,string&gt;**



### setSaveFunction

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setSaveFunction(callable $saveFunction)





* Visibility: **public**


#### Arguments
* $saveFunction **callable**



### setInitialFieldValue

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setInitialFieldValue(string $fieldName, mixed $value)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $value **mixed**



### setFieldLabel

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setFieldLabel(string $fieldName, mixed $label)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $label **mixed**



### setFieldChoices

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setFieldChoices(string $fieldName, array $choices)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $choices **array**



### setFieldType

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setFieldType(string $fieldName, string $type)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $type **string**



### setFieldHelptext

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setFieldHelptext(string $fieldName, string $helptext)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $helptext **string**



### setFieldPlaceholder

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::setFieldPlaceholder(string $fieldName, string $placeholder)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $placeholder **string**



### makeLiteral

    \Athens\Core\Row\RowBuilder Athens\Core\Row\RowBuilder::makeLiteral()





* Visibility: **public**




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



