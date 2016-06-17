Athens\Core\Admin\Admin
===============

Class ObjectManager




* Class name: Admin
* Namespace: Athens\Core\Admin
* Parent class: [Athens\Core\Page\Page](Athens-Core-Page-Page.md)



Constants
----------


### MODE_TABLE

    const MODE_TABLE = 'table'





### MODE_DETAIL

    const MODE_DETAIL = 'detail'





### MODE_DELETE

    const MODE_DELETE = 'delete'





### OBJECT_ID_FIELD

    const OBJECT_ID_FIELD = 'object_id'





### QUERY_INDEX_FIELD

    const QUERY_INDEX_FIELD = 'query_index'





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





Properties
----------


### $queries

    protected array<mixed,\Propel\Runtime\ActiveQuery\ModelCriteria> $queries





* Visibility: **protected**


### $detailPages

    protected \Athens\Core\Admin\{PageInterface $detailPages





* Visibility: **protected**


### $title

    protected string $title





* Visibility: **protected**


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

    protected array<mixed,string> $breadCrumbs





* Visibility: **protected**


### $returnTo

    protected array<mixed,string> $returnTo





* Visibility: **protected**


### $writable

    protected \Athens\Core\Writer\WritableInterface $writable





* Visibility: **protected**


### $type

    protected string $type





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

    mixed Athens\Core\Page\Page::__construct(string $id, string $type, array<mixed,string> $classes, array<mixed,string> $data, string $title, string $baseHref, string $header, string $subHeader, array<mixed,string> $breadCrumbs, array<mixed,string> $returnTo, \Athens\Core\Writer\WritableInterface|null $writable)

Page constructor.



* Visibility: **public**
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)


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



### getObjectId

    integer|null Athens\Core\Admin\Admin::getObjectId()





* Visibility: **public**
* This method is **static**.




### getObjectOr404

    \Propel\Runtime\ActiveRecord\ActiveRecordInterface Athens\Core\Admin\Admin::getObjectOr404()

Finds an object with the given id in this ObjectManager's query.



* Visibility: **protected**




### makeTables

    array<mixed,\Athens\Core\Writer\WritableInterface> Athens\Core\Admin\Admin::makeTables()





* Visibility: **protected**




### makeDetail

    \Athens\Core\Writer\WritableInterface Athens\Core\Admin\Admin::makeDetail()





* Visibility: **protected**




### makeDelete

    \Athens\Core\Writer\WritableInterface Athens\Core\Admin\Admin::makeDelete()





* Visibility: **protected**




### makeUrl

    string Athens\Core\Admin\Admin::makeUrl(string $location, array<mixed,string> $data)





* Visibility: **protected**
* This method is **static**.


#### Arguments
* $location **string**
* $data **array&lt;mixed,string&gt;**



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




### makeDefaultInitializer

    \Athens\Core\Initializer\Initializer Athens\Core\Page\Page::makeDefaultInitializer()





* Visibility: **protected**
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)




### makeDefaultWriter

    \Athens\Core\Writer\Writer Athens\Core\Page\Page::makeDefaultWriter()





* Visibility: **protected**
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)




### areAllTableInterface

    boolean Athens\Core\Page\Page::areAllTableInterface(array<mixed,\Athens\Core\Writer\WritableInterface> $writables)





* Visibility: **protected**
* This method is **static**.
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)


#### Arguments
* $writables **array&lt;mixed,\Athens\Core\Writer\WritableInterface&gt;**



### renderExcel

    void Athens\Core\Page\Page::renderExcel(\Athens\Core\Page\PageInterface $writable, \Athens\Core\Writer\Writer $writer)





* Visibility: **protected**
* This method is **static**.
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)


#### Arguments
* $writable **[Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)**



### renderPDF

    void Athens\Core\Page\Page::renderPDF(\Athens\Core\Page\PageInterface $writable, \Athens\Core\Writer\Writer $writer)





* Visibility: **protected**
* This method is **static**.
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)


#### Arguments
* $writable **[Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)**
* $writer **[Athens\Core\Writer\Writer](Athens-Core-Writer-Writer.md)**



### makeDefaultRendererFunction

    callable Athens\Core\Page\Page::makeDefaultRendererFunction()





* Visibility: **protected**
* This method is defined by [Athens\Core\Page\Page](Athens-Core-Page-Page.md)




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



