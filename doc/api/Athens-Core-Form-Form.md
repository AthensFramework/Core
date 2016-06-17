Athens\Core\Form\Form
===============

Class Form contains fields and tests them for submission-validity.




* Class name: Form
* Namespace: Athens\Core\Form
* This class implements: [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)






Methods
-------


### __construct

    mixed Athens\Core\Form\Form::__construct(string $id, array<mixed,string> $classes, array $data, string $type, string $method, string $target, \Athens\Core\FieldBearer\FieldBearerInterface $fieldBearer, callable $onValidFunc, callable $onInvalidFunc, array|null $actions, array|null $subForms, array<mixed,array>|null $validators)





* Visibility: **public**


#### Arguments
* $id **string**
* $classes **array&lt;mixed,string&gt;**
* $data **array**
* $type **string**
* $method **string**
* $target **string**
* $fieldBearer **[Athens\Core\FieldBearer\FieldBearerInterface](Athens-Core-FieldBearer-FieldBearerInterface.md)**
* $onValidFunc **callable**
* $onInvalidFunc **callable**
* $actions **array|null**
* $subForms **array|null**
* $validators **array&lt;mixed,array&gt;|null**



### getType

    string Athens\Core\Form\FormInterface::getType()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getMethod

    string Athens\Core\Form\FormInterface::getMethod()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getTarget

    string Athens\Core\Form\FormInterface::getTarget()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getFieldBearer

    \Athens\Core\FieldBearer\FieldBearerInterface Athens\Core\Form\FormInterface::getFieldBearer()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### onValid

    void Athens\Core\Form\FormInterface::onValid()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### onInvalid

    void Athens\Core\Form\FormInterface::onInvalid()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### isValid

    boolean Athens\Core\Form\FormInterface::isValid()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### addError

    void Athens\Core\Form\FormInterface::addError(string $error)





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)


#### Arguments
* $error **string**



### getErrors

    array<mixed,string> Athens\Core\Form\FormInterface::getErrors()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getActions

    array<mixed,\Athens\Core\Form\FormAction\FormAction> Athens\Core\Form\FormInterface::getActions()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getSubForms

    array<mixed,\Athens\Core\Form\FormInterface> Athens\Core\Form\FormInterface::getSubForms()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getSubFormByName

    \Athens\Core\Form\FormInterface Athens\Core\Form\FormInterface::getSubFormByName(string $name)





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)


#### Arguments
* $name **string**



### propagateOnValid

    void Athens\Core\Form\FormInterface::propagateOnValid()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### accept

    mixed Athens\Core\Visitor\VisitableInterface::accept(\Athens\Core\Visitor\Visitor $visitor)

Accept a visitor, per the Visitor pattern.



* Visibility: **public**
* This method is defined by [Athens\Core\Visitor\VisitableInterface](Athens-Core-Visitor-VisitableInterface.md)


#### Arguments
* $visitor **[Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)**



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



