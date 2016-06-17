Athens\Core\Field\Field
===============

Class Field provides a small, typed data container for display and
user submission.




* Class name: Field
* Namespace: Athens\Core\Field
* This class implements: [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


Constants
----------


### FIELD_TYPE_TEXT

    const FIELD_TYPE_TEXT = "text"





### FIELD_TYPE_TEXTAREA

    const FIELD_TYPE_TEXTAREA = "textarea"





### FIELD_TYPE_BOOLEAN

    const FIELD_TYPE_BOOLEAN = "boolean"





### FIELD_TYPE_CHECKBOX

    const FIELD_TYPE_CHECKBOX = "checkbox"





### FIELD_TYPE_BOOLEAN_RADIOS

    const FIELD_TYPE_BOOLEAN_RADIOS = "boolean-radios"





### FIELD_TYPE_CHOICE

    const FIELD_TYPE_CHOICE = "choice"





### FIELD_TYPE_MULTIPLE_CHOICE

    const FIELD_TYPE_MULTIPLE_CHOICE = "multiple-choice"





### FIELD_TYPE_LITERAL

    const FIELD_TYPE_LITERAL = "literal"





### FIELD_TYPE_SECTION_LABEL

    const FIELD_TYPE_SECTION_LABEL = "section-label"





### FIELD_TYPE_PRIMARY_KEY

    const FIELD_TYPE_PRIMARY_KEY = "primary-key"





### FIELD_TYPE_FOREIGN_KEY

    const FIELD_TYPE_FOREIGN_KEY = "foreign-key"





### FIELD_TYPE_AUTO_TIMESTAMP

    const FIELD_TYPE_AUTO_TIMESTAMP = "auto-timestamp"





### FIELD_TYPE_VERSION

    const FIELD_TYPE_VERSION = "version"







Methods
-------


### getId

    string Athens\Core\Writer\WritableInterface::getId()

Return a unique identifier that will be consistent between requests.



* Visibility: **public**
* This method is defined by [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)




### __construct

    mixed Athens\Core\Field\Field::__construct(array<mixed,string> $classes, array<mixed,string> $data, string $type, string $label, string|null $initial, boolean $required, array<mixed,string> $choices, integer $fieldSize, string $helptext, string $placeholder)





* Visibility: **public**


#### Arguments
* $classes **array&lt;mixed,string&gt;**
* $data **array&lt;mixed,string&gt;**
* $type **string**
* $label **string**
* $initial **string|null**
* $required **boolean**
* $choices **array&lt;mixed,string&gt;**
* $fieldSize **integer**
* $helptext **string**
* $placeholder **string**



### getSubmitted

    string Athens\Core\Field\FieldInterface::getSubmitted()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### wasSubmitted

    boolean Athens\Core\Field\FieldInterface::wasSubmitted()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getLabel

    string Athens\Core\Field\FieldInterface::getLabel()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setLabel

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setLabel(string $label)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $label **string**



### getChoices

    array<mixed,string> Athens\Core\Field\FieldInterface::getChoices()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getChoiceSlugs

    array<mixed,string> Athens\Core\Field\FieldInterface::getChoiceSlugs()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setChoices

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setChoices(array $choices)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $choices **array**



### getSize

    integer Athens\Core\Field\FieldInterface::getSize()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setSize

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setSize(integer $size)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $size **integer**



### getType

    string Athens\Core\Field\FieldInterface::getType()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setType

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setType(string $type)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $type **string**



### addSuffix

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addSuffix(string $suffix)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $suffix **string**



### getSuffixes

    array<mixed,string> Athens\Core\Field\FieldInterface::getSuffixes()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### addPrefix

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addPrefix(string $prefix)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $prefix **string**



### getPrefixes

    array<mixed,string> Athens\Core\Field\FieldInterface::getPrefixes()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getLabelSlug

    string Athens\Core\Field\FieldInterface::getLabelSlug()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getSlug

    string Athens\Core\Field\FieldInterface::getSlug()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setInitial

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setInitial(string|array<mixed,string> $value)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $value **string|array&lt;mixed,string&gt;**



### getInitial

    string|array<mixed,string> Athens\Core\Field\FieldInterface::getInitial()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### addError

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::addError(string $error)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $error **string**



### getErrors

    array<mixed,string> Athens\Core\Field\FieldInterface::getErrors()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### removeErrors

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::removeErrors()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### validate

    void Athens\Core\Field\FieldInterface::validate()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### isRequired

    boolean Athens\Core\Field\FieldInterface::isRequired()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setRequired

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setRequired(boolean $required)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $required **boolean**



### isValid

    boolean Athens\Core\Field\FieldInterface::isValid()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setValidatedData

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setValidatedData(string $data)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $data **string**



### hasValidatedData

    boolean Athens\Core\Field\FieldInterface::hasValidatedData()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getValidatedData

    string Athens\Core\Field\FieldInterface::getValidatedData()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### getHelptext

    string Athens\Core\Field\FieldInterface::getHelptext()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setHelptext

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setHelptext(string $helptext)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $helptext **string**



### getPlaceholder

    string Athens\Core\Field\FieldInterface::getPlaceholder()





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)




### setPlaceholder

    \Athens\Core\Field\FieldInterface Athens\Core\Field\FieldInterface::setPlaceholder(string $placeholder)





* Visibility: **public**
* This method is defined by [Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)


#### Arguments
* $placeholder **string**



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


