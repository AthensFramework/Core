Athens\Core\Page\PageBuilder
===============

Class PageBuilder




* Class name: PageBuilder
* Namespace: Athens\Core\Page
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)





Properties
----------


### $baseHref

    protected string $baseHref





* Visibility: **protected**


### $header

    protected string $header





* Visibility: **protected**


### $subHeader

    protected string $subHeader





* Visibility: **protected**


### $breadCrumbs

    protected array<mixed,string> $breadCrumbs = array()





* Visibility: **protected**


### $returnTo

    protected array<mixed,string> $returnTo = array()





* Visibility: **protected**


### $writable

    protected \Athens\Core\Writer\WritableInterface $writable





* Visibility: **protected**


### $type

    protected string $type





* Visibility: **protected**


### $title

    protected string $title





* Visibility: **protected**


### $message

    protected array<mixed,string> $message





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

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### setTitle

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setTitle(string $title)





* Visibility: **public**


#### Arguments
* $title **string**



### setBaseHref

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setBaseHref(string $baseHref)





* Visibility: **public**


#### Arguments
* $baseHref **string**



### setHeader

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setHeader(string $header)





* Visibility: **public**


#### Arguments
* $header **string**



### setSubHeader

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setSubHeader(string $subHeader)





* Visibility: **public**


#### Arguments
* $subHeader **string**



### setBreadCrumbs

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setBreadCrumbs(array<mixed,string> $breadCrumbs)





* Visibility: **public**


#### Arguments
* $breadCrumbs **array&lt;mixed,string&gt;**



### setReturnTo

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setReturnTo(array<mixed,string> $returnTo)





* Visibility: **public**


#### Arguments
* $returnTo **array&lt;mixed,string&gt;**



### setWritable

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setWritable(\Athens\Core\Writer\WritableInterface $writable)





* Visibility: **public**


#### Arguments
* $writable **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)**



### setMessage

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setMessage(array<mixed,string> $message)





* Visibility: **public**


#### Arguments
* $message **array&lt;mixed,string&gt;**



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



