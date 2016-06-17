Athens\Core\Email\EmailBuilder
===============

Class EmailBuilder




* Class name: EmailBuilder
* Namespace: Athens\Core\Email
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)





Properties
----------


### $type

    protected string $type = "base"





* Visibility: **protected**


### $subject

    protected string $subject





* Visibility: **protected**


### $message

    protected string $message





* Visibility: **protected**


### $to

    protected string $to





* Visibility: **protected**


### $from

    protected string $from





* Visibility: **protected**


### $cc

    protected string $cc





* Visibility: **protected**


### $bcc

    protected string $bcc





* Visibility: **protected**


### $xMailer

    protected string $xMailer





* Visibility: **protected**


### $contentType

    protected string $contentType





* Visibility: **protected**


### $mimeVersion

    protected string $mimeVersion





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


### setType

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### setSubject

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setSubject(string $subject)





* Visibility: **public**


#### Arguments
* $subject **string**



### setMessage

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setMessage(string $message)





* Visibility: **public**


#### Arguments
* $message **string**



### setLiteralMessage

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setLiteralMessage(string $message)





* Visibility: **public**


#### Arguments
* $message **string**



### setTo

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setTo(string $to)





* Visibility: **public**


#### Arguments
* $to **string**



### setFrom

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setFrom(string $from)





* Visibility: **public**


#### Arguments
* $from **string**



### setCc

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setCc(string $cc)





* Visibility: **public**


#### Arguments
* $cc **string**



### setBcc

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setBcc(string $bcc)





* Visibility: **public**


#### Arguments
* $bcc **string**



### setXMailer

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setXMailer(string $xMailer)





* Visibility: **public**


#### Arguments
* $xMailer **string**



### setContentType

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setContentType(string $contentType)





* Visibility: **public**


#### Arguments
* $contentType **string**



### setMimeVersion

    \Athens\Core\Email\EmailBuilder Athens\Core\Email\EmailBuilder::setMimeVersion(string $mimeVersion)





* Visibility: **public**


#### Arguments
* $mimeVersion **string**



### build

    mixed Athens\Core\Etc\AbstractBuilder::build()

Return the element under construction.

Returns an instance of the object type under construction.

* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### begin

    static Athens\Core\Etc\AbstractBuilder::begin()





* Visibility: **public**
* This method is **static**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### clear

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::clear()





* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### setId

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::setId(string $id)

Set the unique identifier for the element to be built.



* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $id **string**



### addClass

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::addClass(string $class)

Add a display class name to the element to be built.



* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $class **string**



### addData

    \Athens\Core\Etc\AbstractBuilder Athens\Core\Etc\AbstractBuilder::addData(string $key, string $value)

Add a data field to the element to be built.

For example, when building a field:

FieldBuilder->begin()
    ->addData('owned-by', 'bob')
    ...
    ->build();

When written to HTML, the resulting field will have
an HTML5 data attribute like:

    <... data-owned-by='bob' .../>

* Visibility: **public**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)


#### Arguments
* $key **string**
* $value **string**



### validateId

    void Athens\Core\Etc\AbstractBuilder::validateId()

Assert that a unique identifier has been provided for the element to be built.



* Visibility: **protected**
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)



