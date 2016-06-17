Athens\Core\Form\FormInterface
===============






* Interface name: FormInterface
* Namespace: Athens\Core\Form
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md), [Athens\Core\Initializer\InitializableInterface](Athens-Core-Initializer-InitializableInterface.md)





Methods
-------


### getType

    string Athens\Core\Form\FormInterface::getType()





* Visibility: **public**




### getMethod

    string Athens\Core\Form\FormInterface::getMethod()





* Visibility: **public**




### getTarget

    string Athens\Core\Form\FormInterface::getTarget()





* Visibility: **public**




### getFieldBearer

    \Athens\Core\FieldBearer\FieldBearerInterface Athens\Core\Form\FormInterface::getFieldBearer()





* Visibility: **public**




### getSubForms

    array<mixed,\Athens\Core\Form\FormInterface> Athens\Core\Form\FormInterface::getSubForms()





* Visibility: **public**




### getSubFormByName

    \Athens\Core\Form\FormInterface Athens\Core\Form\FormInterface::getSubFormByName(string $name)





* Visibility: **public**


#### Arguments
* $name **string**



### isValid

    boolean Athens\Core\Form\FormInterface::isValid()





* Visibility: **public**




### onValid

    void Athens\Core\Form\FormInterface::onValid()





* Visibility: **public**




### onInvalid

    void Athens\Core\Form\FormInterface::onInvalid()





* Visibility: **public**




### getErrors

    array<mixed,string> Athens\Core\Form\FormInterface::getErrors()





* Visibility: **public**




### getActions

    array<mixed,\Athens\Core\Form\FormAction\FormAction> Athens\Core\Form\FormInterface::getActions()





* Visibility: **public**




### addError

    void Athens\Core\Form\FormInterface::addError(string $error)





* Visibility: **public**


#### Arguments
* $error **string**



### propagateOnValid

    void Athens\Core\Form\FormInterface::propagateOnValid()





* Visibility: **public**




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


