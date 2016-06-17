Athens\Core\Test\Mock\LoggingEmailer
===============

Class LoggingEmailer Sends emails by logging them to the error log.




* Class name: LoggingEmailer
* Namespace: Athens\Core\Test\Mock
* Parent class: [Athens\Core\Emailer\PhpEmailer](Athens-Core-Emailer-PhpEmailer.md)







Methods
-------


### buildMessage

    string Athens\Core\Test\Mock\LoggingEmailer::buildMessage(string $body, \Athens\Core\Email\EmailInterface $email)

Constructs a single string from the email body and headers.



* Visibility: **protected**


#### Arguments
* $body **string**
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**



### doSend

    boolean Athens\Core\Emailer\AbstractEmailer::doSend(string $body, \Athens\Core\Email\EmailInterface $email)

Each Emailer must have a ::doSend which performs the actual sending of
the email.



* Visibility: **protected**
* This method is **abstract**.
* This method is defined by [Athens\Core\Emailer\AbstractEmailer](Athens-Core-Emailer-AbstractEmailer.md)


#### Arguments
* $body **string**
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**



### buildHeaders

    string Athens\Core\Emailer\PhpEmailer::buildHeaders(\Athens\Core\Email\EmailInterface $email)





* Visibility: **protected**
* This method is defined by [Athens\Core\Emailer\PhpEmailer](Athens-Core-Emailer-PhpEmailer.md)


#### Arguments
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**



### send

    boolean Athens\Core\Emailer\EmailerInterface::send(\Athens\Core\Email\EmailInterface $email, \Athens\Core\Writer\Writer|null $writer)





* Visibility: **public**
* This method is defined by [Athens\Core\Emailer\EmailerInterface](Athens-Core-Emailer-EmailerInterface.md)


#### Arguments
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)|null**


