Athens\Core\FieldBearer\FieldBearerBuilder
===============

Class FieldBearerBuilder




* Class name: FieldBearerBuilder
* Namespace: Athens\Core\FieldBearer
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)







Methods
-------


### addFieldBearers

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::addFieldBearers(array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> $fieldBearers)





* Visibility: **public**


#### Arguments
* $fieldBearers **array&lt;mixed,\Athens\Core\FieldBearer\FieldBearerInterface&gt;**



### addFields

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::addFields(array<mixed,\Athens\Core\Field\FieldInterface> $fields)





* Visibility: **public**


#### Arguments
* $fields **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**



### addObject

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::addObject(\Propel\Runtime\ActiveRecord\ActiveRecordInterface $object)





* Visibility: **public**


#### Arguments
* $object **Propel\Runtime\ActiveRecord\ActiveRecordInterface**



### addClassTableMapName

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::addClassTableMapName(string $classTableMapName)





* Visibility: **public**


#### Arguments
* $classTableMapName **string**



### setVisibleFieldNames

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setVisibleFieldNames(array<mixed,\string> $visibleFieldNames)





* Visibility: **public**


#### Arguments
* $visibleFieldNames **array&lt;mixed,\string&gt;**



### setHiddenFieldNames

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setHiddenFieldNames(array<mixed,string> $hiddenFieldNames)





* Visibility: **public**


#### Arguments
* $hiddenFieldNames **array&lt;mixed,string&gt;**



### setSaveFunction

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setSaveFunction(callable $saveFunction)





* Visibility: **public**


#### Arguments
* $saveFunction **callable**



### setInitialFieldValue

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setInitialFieldValue(string $fieldName, mixed $value)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $value **mixed**



### setFieldLabel

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setFieldLabel(string $fieldName, mixed $label)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $label **mixed**



### setFieldChoices

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setFieldChoices(string $fieldName, array $choices)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $choices **array**



### setFieldType

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setFieldType(string $fieldName, string $type)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $type **string**



### setFieldHelptext

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setFieldHelptext(string $fieldName, string $helptext)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $helptext **string**



### setFieldPlaceholder

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::setFieldPlaceholder(string $fieldName, string $placeholder)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $placeholder **string**



### makeLiteral

    \Athens\Core\FieldBearer\FieldBearerBuilder Athens\Core\FieldBearer\FieldBearerBuilder::makeLiteral()





* Visibility: **public**




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


