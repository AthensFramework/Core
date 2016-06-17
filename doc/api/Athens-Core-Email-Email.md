Athens\Core\Email\Email
===============

Class Email encapsulates the data which consitutes an email.




* Class name: Email
* Namespace: Athens\Core\Email
* This class implements: [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)






Methods
-------


### __construct

    mixed Athens\Core\Email\Email::__construct(string $type, string $subject, string $message, string $to, string $from, string $cc, string $bcc, string $xMailer, string $contentType, string $mimeVersion)

Email constructor.



* Visibility: **public**


#### Arguments
* $type **string**
* $subject **string**
* $message **string**
* $to **string**
* $from **string**
* $cc **string**
* $bcc **string**
* $xMailer **string**
* $contentType **string**
* $mimeVersion **string**



### getType

    string Athens\Core\Email\EmailInterface::getType()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getSubject

    string Athens\Core\Email\EmailInterface::getSubject()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getMessage

    string Athens\Core\Email\EmailInterface::getMessage()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getTo

    string Athens\Core\Email\EmailInterface::getTo()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getFrom

    string Athens\Core\Email\EmailInterface::getFrom()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getCc

    string Athens\Core\Email\EmailInterface::getCc()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getBcc

    string Athens\Core\Email\EmailInterface::getBcc()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getXMailer

    string Athens\Core\Email\EmailInterface::getXMailer()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getContentType

    string Athens\Core\Email\EmailInterface::getContentType()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




### getMimeVersion

    string Athens\Core\Email\EmailInterface::getMimeVersion()





* Visibility: **public**
* This method is defined by [Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)




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


