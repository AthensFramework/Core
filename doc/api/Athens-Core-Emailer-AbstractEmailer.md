Athens\Core\Emailer\AbstractEmailer
===============

Class AbstractEmailer provides the framework for rendering an email body before
sending it.




* Class name: AbstractEmailer
* Namespace: Athens\Core\Emailer
* This is an **abstract** class
* This class implements: [Athens\Core\Emailer\EmailerInterface](Athens-Core-Emailer-EmailerInterface.md)






Methods
-------


### doSend

    boolean Athens\Core\Emailer\AbstractEmailer::doSend(string $body, \Athens\Core\Email\EmailInterface $email)

Each Emailer must have a ::doSend which performs the actual sending of
the email.



* Visibility: **protected**
* This method is **abstract**.


#### Arguments
* $body **string**
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**



### send

    boolean Athens\Core\Emailer\EmailerInterface::send(\Athens\Core\Email\EmailInterface $email, \Athens\Core\Writer\Writer|null $writer)





* Visibility: **public**
* This method is defined by [Athens\Core\Emailer\EmailerInterface](Athens-Core-Emailer-EmailerInterface.md)


#### Arguments
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)|null**


