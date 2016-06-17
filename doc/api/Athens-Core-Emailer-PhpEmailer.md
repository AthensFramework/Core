Athens\Core\Emailer\PhpEmailer
===============

Class PhpEmailer provides an EmailerInterface for PHP&#039;s mail method.




* Class name: PhpEmailer
* Namespace: Athens\Core\Emailer
* Parent class: [Athens\Core\Emailer\AbstractEmailer](Athens-Core-Emailer-AbstractEmailer.md)







Methods
-------


### buildHeaders

    string Athens\Core\Emailer\PhpEmailer::buildHeaders(\Athens\Core\Email\EmailInterface $email)





* Visibility: **protected**


#### Arguments
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



### send

    boolean Athens\Core\Emailer\EmailerInterface::send(\Athens\Core\Email\EmailInterface $email, \Athens\Core\Writer\Writer|null $writer)





* Visibility: **public**
* This method is defined by [Athens\Core\Emailer\EmailerInterface](Athens-Core-Emailer-EmailerInterface.md)


#### Arguments
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)|null**


