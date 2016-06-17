Athens\Core\Email\EmailInterface
===============






* Interface name: EmailInterface
* Namespace: Athens\Core\Email
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)





Methods
-------


### getType

    string Athens\Core\Email\EmailInterface::getType()





* Visibility: **public**




### getSubject

    string Athens\Core\Email\EmailInterface::getSubject()





* Visibility: **public**




### getMessage

    string Athens\Core\Email\EmailInterface::getMessage()





* Visibility: **public**




### getTo

    string Athens\Core\Email\EmailInterface::getTo()





* Visibility: **public**




### getFrom

    string Athens\Core\Email\EmailInterface::getFrom()





* Visibility: **public**




### getCc

    string Athens\Core\Email\EmailInterface::getCc()





* Visibility: **public**




### getBcc

    string Athens\Core\Email\EmailInterface::getBcc()





* Visibility: **public**




### getXMailer

    string Athens\Core\Email\EmailInterface::getXMailer()





* Visibility: **public**




### getContentType

    string Athens\Core\Email\EmailInterface::getContentType()





* Visibility: **public**




### getMimeVersion

    string Athens\Core\Email\EmailInterface::getMimeVersion()





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


