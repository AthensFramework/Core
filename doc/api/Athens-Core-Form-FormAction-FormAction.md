Athens\Core\Form\FormAction\FormAction
===============

Class FormAction




* Class name: FormAction
* Namespace: Athens\Core\Form\FormAction
* This class implements: [Athens\Core\Form\FormAction\FormActionInterface](Athens-Core-Form-FormAction-FormActionInterface.md)




Properties
----------


### $label

    protected string $label





* Visibility: **protected**


### $method

    protected string $method





* Visibility: **protected**


### $target

    protected string $target





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


### __construct

    mixed Athens\Core\Form\FormAction\FormAction::__construct(array<mixed,string> $classes, array $data, string $label, string $method, string $target)





* Visibility: **public**


#### Arguments
* $classes **array&lt;mixed,string&gt;**
* $data **array**
* $label **string**
* $method **string**
* $target **string**



### getMethod

    string Athens\Core\Form\FormAction\FormActionInterface::getMethod()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormAction\FormActionInterface](Athens-Core-Form-FormAction-FormActionInterface.md)




### getTarget

    string Athens\Core\Form\FormAction\FormActionInterface::getTarget()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormAction\FormActionInterface](Athens-Core-Form-FormAction-FormActionInterface.md)




### getLabel

    string Athens\Core\Form\FormAction\FormActionInterface::getLabel()





* Visibility: **public**
* This method is defined by [Athens\Core\Form\FormAction\FormActionInterface](Athens-Core-Form-FormAction-FormActionInterface.md)




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



