Athens\Core\Page\PageInterface
===============






* Interface name: PageInterface
* Namespace: Athens\Core\Page
* This is an **interface**
* This interface extends: [Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md), [Athens\Core\Initializer\InitializableInterface](Athens-Core-Initializer-InitializableInterface.md)





Methods
-------


### getTitle

    string Athens\Core\Page\PageInterface::getTitle()





* Visibility: **public**




### getBaseHref

    string Athens\Core\Page\PageInterface::getBaseHref()





* Visibility: **public**




### getHeader

    string Athens\Core\Page\PageInterface::getHeader()





* Visibility: **public**




### getSubHeader

    string Athens\Core\Page\PageInterface::getSubHeader()





* Visibility: **public**




### getType

    string Athens\Core\Page\PageInterface::getType()





* Visibility: **public**




### getBreadCrumbs

    array<mixed,string> Athens\Core\Page\PageInterface::getBreadCrumbs()





* Visibility: **public**




### getReturnTo

    array<mixed,string> Athens\Core\Page\PageInterface::getReturnTo()





* Visibility: **public**




### getWritable

    \Athens\Core\Writer\WritableInterface Athens\Core\Page\PageInterface::getWritable()





* Visibility: **public**




### render

    mixed Athens\Core\Page\PageInterface::render(\Athens\Core\Initializer\Initializer|null $initializer, \Athens\Core\Writer\Writer|null $writer)





* Visibility: **public**


#### Arguments
* $initializer **[Athens\Core\Initializer\Initializer](Athens-Core-Initializer-Initializer.md)|null**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)|null**



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


