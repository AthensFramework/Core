Athens\Core\FieldBearer\FieldBearerInterface
===============






* Interface name: FieldBearerInterface
* Namespace: Athens\Core\FieldBearer
* This is an **interface**
* This interface extends: [Athens\Core\Initializer\InitializableInterface](Athens-Core-Initializer-InitializableInterface.md)





Methods
-------


### getFieldBearers

    array<mixed,\Athens\Core\FieldBearer\FieldBearerInterface> Athens\Core\FieldBearer\FieldBearerInterface::getFieldBearers()





* Visibility: **public**




### getFieldBearerByName

    \Athens\Core\FieldBearer\FieldBearerInterface Athens\Core\FieldBearer\FieldBearerInterface::getFieldBearerByName(string $name)





* Visibility: **public**


#### Arguments
* $name **string**



### getFieldByName

    \Athens\Core\Field\FieldInterface Athens\Core\FieldBearer\FieldBearerInterface::getFieldByName(string $name)

Given a field's string name, return the field.



* Visibility: **public**


#### Arguments
* $name **string**



### getNameByField

    string Athens\Core\FieldBearer\FieldBearerInterface::getNameByField(\Athens\Core\Field\FieldInterface $field)





* Visibility: **public**


#### Arguments
* $field **[Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)**



### getFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getFields()

Return the array of child fields.



* Visibility: **public**




### getVisibleFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleFields()





* Visibility: **public**




### getHiddenFields

    array<mixed,\Athens\Core\Field\FieldInterface> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenFields()





* Visibility: **public**




### getFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getFieldNames()





* Visibility: **public**




### getVisibleFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleFieldNames()





* Visibility: **public**




### getHiddenFieldNames

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenFieldNames()





* Visibility: **public**




### getLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getLabels()

Return the labels of the child fields.



* Visibility: **public**




### getVisibleLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getVisibleLabels()





* Visibility: **public**




### getHiddenLabels

    array<mixed,String> Athens\Core\FieldBearer\FieldBearerInterface::getHiddenLabels()





* Visibility: **public**




### save

    mixed Athens\Core\FieldBearer\FieldBearerInterface::save()





* Visibility: **public**




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**


