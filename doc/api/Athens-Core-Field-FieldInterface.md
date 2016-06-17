Athens\Core\Field\FieldInterface
===============






* Interface name: FieldInterface
* Namespace: Athens\Core\Field
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)





Methods
-------


### getSubmitted

    string Athens\Core\Field\FieldInterface::getSubmitted()





* Visibility: **public**




### wasSubmitted

    boolean Athens\Core\Field\FieldInterface::wasSubmitted()





* Visibility: **public**




### getLabel

    string Athens\Core\Field\FieldInterface::getLabel()





* Visibility: **public**




### setLabel

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setLabel(string $label)





* Visibility: **public**


#### Arguments
* $label **string**



### getChoices

    array<mixed,string> Athens\Core\Field\FieldInterface::getChoices()





* Visibility: **public**




### getChoiceSlugs

    array<mixed,string> Athens\Core\Field\FieldInterface::getChoiceSlugs()





* Visibility: **public**




### setChoices

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setChoices(array $choices)





* Visibility: **public**


#### Arguments
* $choices **array**



### getSize

    integer Athens\Core\Field\FieldInterface::getSize()





* Visibility: **public**




### setSize

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setSize(integer $size)





* Visibility: **public**


#### Arguments
* $size **integer**



### getType

    string Athens\Core\Field\FieldInterface::getType()





* Visibility: **public**




### setType

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### addSuffix

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addSuffix(string $suffix)





* Visibility: **public**


#### Arguments
* $suffix **string**



### getSuffixes

    array<mixed,string> Athens\Core\Field\FieldInterface::getSuffixes()





* Visibility: **public**




### addPrefix

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addPrefix(string $prefix)





* Visibility: **public**


#### Arguments
* $prefix **string**



### getPrefixes

    array<mixed,string> Athens\Core\Field\FieldInterface::getPrefixes()





* Visibility: **public**




### getLabelSlug

    string Athens\Core\Field\FieldInterface::getLabelSlug()





* Visibility: **public**




### getSlug

    string Athens\Core\Field\FieldInterface::getSlug()





* Visibility: **public**




### setInitial

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setInitial(string|array<mixed,string> $value)





* Visibility: **public**


#### Arguments
* $value **string|array&lt;mixed,string&gt;**



### getInitial

    string|array<mixed,string> Athens\Core\Field\FieldInterface::getInitial()





* Visibility: **public**




### addError

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addError(string $error)





* Visibility: **public**


#### Arguments
* $error **string**



### getErrors

    array<mixed,string> Athens\Core\Field\FieldInterface::getErrors()





* Visibility: **public**




### removeErrors

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::removeErrors()





* Visibility: **public**




### validate

    void Athens\Core\Field\FieldInterface::validate()





* Visibility: **public**




### isRequired

    boolean Athens\Core\Field\FieldInterface::isRequired()





* Visibility: **public**




### setRequired

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setRequired(boolean $required)





* Visibility: **public**


#### Arguments
* $required **boolean**



### isValid

    boolean Athens\Core\Field\FieldInterface::isValid()





* Visibility: **public**




### setValidatedData

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setValidatedData(string $data)





* Visibility: **public**


#### Arguments
* $data **string**



### hasValidatedData

    boolean Athens\Core\Field\FieldInterface::hasValidatedData()





* Visibility: **public**




### getValidatedData

    string Athens\Core\Field\FieldInterface::getValidatedData()





* Visibility: **public**




### getHelptext

    string Athens\Core\Field\FieldInterface::getHelptext()





* Visibility: **public**




### setHelptext

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setHelptext(string $helptext)





* Visibility: **public**


#### Arguments
* $helptext **string**



### getPlaceholder

    string Athens\Core\Field\FieldInterface::getPlaceholder()





* Visibility: **public**




### setPlaceholder

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setPlaceholder(string $placeholder)





* Visibility: **public**


#### Arguments
* $placeholder **string**



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




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**


