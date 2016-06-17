Athens\Core\Table\TableFormInterface
===============






* Interface name: TableFormInterface
* Namespace: Athens\Core\Table
* This is an **interface**
* This interface extends: [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md), [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)





Methods
-------


### getPrototypicalRow

    \Athens\Core\Row\RowInterface Athens\Core\Table\TableFormInterface::getPrototypicalRow()





* Visibility: **public**




### getCanRemove

    boolean Athens\Core\Table\TableFormInterface::getCanRemove()





* Visibility: **public**




### getRows

    array<mixed,\Athens\Core\Row\RowInterface> Athens\Core\Table\TableInterface::getRows()





* Visibility: **public**
* This method is defined by [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)




### getFilter

    \Athens\Core\Filter\FilterInterface Athens\Core\Table\TableInterface::getFilter()





* Visibility: **public**
* This method is defined by [Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)




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



### isValid

    boolean Athens\Core\Form\FormInterface::isValid()





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




### getErrors

    array<mixed,string> Athens\Core\Form\FormInterface::getErrors()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### getActions

    array<mixed,\Athens\Core\Form\FormAction\FormAction> Athens\Core\Form\FormInterface::getActions()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)




### addError

    void Athens\Core\Form\FormInterface::addError(string $error)





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)


#### Arguments
* $error **string**



### propagateOnValid

    void Athens\Core\Form\FormInterface::propagateOnValid()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)



