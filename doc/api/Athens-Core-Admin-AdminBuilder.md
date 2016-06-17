Athens\Core\Admin\AdminBuilder
===============

Class PageBuilder




* Class name: AdminBuilder
* Namespace: Athens\Core\Admin
* Parent class: [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)







Methods
-------


### setWritable

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setWritable(\Athens\Core\Writer\WritableInterface $writable)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $writable **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)**



### setMessage

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setMessage(array<mixed,string> $message)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $message **array&lt;mixed,string&gt;**



### addQuery

    \Athens\Core\Page\PageBuilder Athens\Core\Admin\AdminBuilder::addQuery(\Propel\Runtime\ActiveQuery\ModelCriteria $objectManagerQuery, \Athens\Core\Writer\WritableInterface $detailPage)





* Visibility: **public**


#### Arguments
* $objectManagerQuery **Propel\Runtime\ActiveQuery\ModelCriteria**
* $detailPage **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)**



### build

    mixed Athens\Core\Etc\AbstractBuilder::build()

Return the element under construction.

Returns an instance of the object type under construction.

* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### setType

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setType(string $type)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $type **string**



### setTitle

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setTitle(string $title)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $title **string**



### setBaseHref

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setBaseHref(string $baseHref)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $baseHref **string**



### setHeader

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setHeader(string $header)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $header **string**



### setSubHeader

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setSubHeader(string $subHeader)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $subHeader **string**



### setBreadCrumbs

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setBreadCrumbs(array<mixed,string> $breadCrumbs)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $breadCrumbs **array&lt;mixed,string&gt;**



### setReturnTo

    \Athens\Core\Page\PageBuilder Athens\Core\Page\PageBuilder::setReturnTo(array<mixed,string> $returnTo)





* Visibility: **public**
* This method is defined by [Athens\Core\Page\PageBuilder](Athens-Core-Page-PageBuilder.md)


#### Arguments
* $returnTo **array&lt;mixed,string&gt;**



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


