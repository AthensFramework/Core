Athens\Core\Page\Page
===============

Class Page Provides the primary writable for a page request.




* Class name: Page
* Namespace: Athens\Core\Page
* This class implements: [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)


Constants
----------


### PAGE_TYPE_AJAX_ACTION

    const PAGE_TYPE_AJAX_ACTION = 'ajax-action'





### PAGE_TYPE_AJAX_PAGE

    const PAGE_TYPE_AJAX_PAGE = 'ajax-page'





### PAGE_TYPE_EXCEL

    const PAGE_TYPE_EXCEL = 'excel'





### PAGE_TYPE_FULL_HEADER

    const PAGE_TYPE_FULL_HEADER = 'full-header'





### PAGE_TYPE_MINI_HEADER

    const PAGE_TYPE_MINI_HEADER = 'mini-header'





### PAGE_TYPE_MULTI_PANEL

    const PAGE_TYPE_MULTI_PANEL = 'multi-panel'





### PAGE_TYPE_PDF

    const PAGE_TYPE_PDF = 'pdf'





### PAGE_TYPE_MARKDOWN_DOCUMENTATION

    const PAGE_TYPE_MARKDOWN_DOCUMENTATION = 'markdown-documentation'







Methods
-------


### __construct

    mixed Athens\Core\Page\Page::__construct(string $id, string $type, array<mixed,string> $classes, array<mixed,string> $data, string $title, string $baseHref, string $header, string $subHeader, array<mixed,string> $breadCrumbs, array<mixed,string> $returnTo, \Athens\Core\Writer\WritableInterface|null $writable)

Page constructor.



* Visibility: **public**


#### Arguments
* $id **string**
* $type **string**
* $classes **array&lt;mixed,string&gt;**
* $data **array&lt;mixed,string&gt;**
* $title **string**
* $baseHref **string**
* $header **string**
* $subHeader **string**
* $breadCrumbs **array&lt;mixed,string&gt;**
* $returnTo **array&lt;mixed,string&gt;**
* $writable **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)|null**



### getType

    string Athens\Core\Page\PageInterface::getType()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getTitle

    string Athens\Core\Page\PageInterface::getTitle()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getBaseHref

    string Athens\Core\Page\PageInterface::getBaseHref()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getHeader

    string Athens\Core\Page\PageInterface::getHeader()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getSubHeader

    string Athens\Core\Page\PageInterface::getSubHeader()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getBreadCrumbs

    array<mixed,string> Athens\Core\Page\PageInterface::getBreadCrumbs()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getReturnTo

    array<mixed,string> Athens\Core\Page\PageInterface::getReturnTo()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### getWritable

    \Athens\Core\Writer\WritableInterface Athens\Core\Page\PageInterface::getWritable()





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)




### render

    mixed Athens\Core\Page\PageInterface::render(\Athens\Core\Initializer\Initializer|null $initializer, \Athens\Core\Writer\Writer|null $writer)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)


#### Arguments
* $initializer **[Athens\Core\Initializer\Initializer](Athens-Core-Initializer-Initializer.md)|null**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)|null**



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



