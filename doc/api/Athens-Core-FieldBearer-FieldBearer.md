Athens\Core\FieldBearer\FieldBearer
===============

Class FieldBearer encapsulates a set of fields and child field bearers.




* Class name: FieldBearer
* Namespace: Athens\Core\FieldBearer
* This class implements: [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




Properties
----------


### $fieldBearers

    protected array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> $fieldBearers = array()





* Visibility: **protected**


### $fields

    protected array<mixed,\Athens\Core\Field\FieldInterface> $fields = array()





* Visibility: **protected**


### $visibleFieldNames

    protected array<mixed,String> $visibleFieldNames = array()





* Visibility: **protected**


### $hiddenFieldNames

    protected array<mixed,String> $hiddenFieldNames = array()





* Visibility: **protected**


### $saveFunction

    protected callable $saveFunction





* Visibility: **protected**


Methods
-------


### __construct

    mixed Athens\Core\FieldBearer\FieldBearer::__construct(array<mixed,\Athens\Core\Field\FieldInterface> $fields, array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> $fieldBearers, array<mixed,string> $visibleFieldNames, array<mixed,string> $hiddenFieldNames, callable|null $saveFunction)





* Visibility: **public**


#### Arguments
* $fields **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**
* $fieldBearers **array&lt;mixed,\Athens\Core\FieldBearer\FieldBearerInterface&gt;**
* $visibleFieldNames **array&lt;mixed,string&gt;**
* $hiddenFieldNames **array&lt;mixed,string&gt;**
* $saveFunction **callable|null**



### getFieldsBase

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearer::getFieldsBase(string $fieldGetterFunction, array<mixed,\Athens\Core\Field\FieldInterface> $initial)





* Visibility: **public**


#### Arguments
* $fieldGetterFunction **string**
* $initial **array&lt;mixed,\Athens\Core\Field\FieldInterface&gt;**



### getFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getFields()

Return the array of child fields.



* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getFieldNames()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getVisibleFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleFieldNames()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getHiddenFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenFieldNames()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getVisibleFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleFields()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getHiddenFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenFields()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getFieldLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearer::getFieldLabels()

Return the labels of the child fields.



* Visibility: **public**




### getFieldByName

    \Athens\Core\Field\FieldInterface Athens\Core\FieldBearer\FieldBearerInterface::getFieldByName(string $name)

Given a field's string name, return the field.



* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)


#### Arguments
* $name **string**



### getNameByField

    string Athens\Core\FieldBearer\FieldBearerInterface::getNameByField(\Athens\Core\Field\FieldInterface $field)





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)


#### Arguments
* $field **[Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)**



### getLabelByFieldName

    string Athens\Core\FieldBearer\FieldBearer::getLabelByFieldName(string $fieldName)





* Visibility: **protected**


#### Arguments
* $fieldName **string**



### getLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getLabels()

Return the labels of the child fields.



* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getVisibleLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleLabels()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getHiddenLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenLabels()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### getFieldBearers

    array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> Athens\Core\FieldBearer\FieldBearerInterface::getFieldBearers()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### baseGetThingByName

    mixed Athens\Core\FieldBearer\FieldBearer::baseGetThingByName(string $thingType, string $name)





* Visibility: **protected**


#### Arguments
* $thingType **string**
* $name **string**



### getFieldBearerByName

    \Athens\Core\FieldBearer\FieldBearerInterface Athens\Core\FieldBearer\FieldBearerInterface::getFieldBearerByName(string $name)





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)


#### Arguments
* $name **string**



### save

    mixed Athens\Core\FieldBearer\FieldBearerInterface::save()





* Visibility: **public**
* This method is defined by [Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**


