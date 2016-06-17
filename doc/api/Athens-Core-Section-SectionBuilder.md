Athens\Core\Section\SectionBuilder
===============

Class SectionBuilder




* Class name: SectionBuilder
* Namespace: Athens\Core\Section
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)







Methods
-------


### addLabel

    \Athens\Core\Section\SectionBuilder Athens\Core\Section\SectionBuilder::addLabel(string $label)





* Visibility: **public**


#### Arguments
* $label **string**



### addContent

    \Athens\Core\Section\SectionBuilder Athens\Core\Section\SectionBuilder::addContent(string $content)





* Visibility: **public**


#### Arguments
* $content **string**



### addLiteralContent

    \Athens\Core\Section\SectionBuilder Athens\Core\Section\SectionBuilder::addLiteralContent(string $content)





* Visibility: **public**


#### Arguments
* $content **string**



### setType

    \Athens\Core\Section\SectionBuilder Athens\Core\Section\SectionBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### addWritable

    \Athens\Core\Section\SectionBuilder Athens\Core\Section\SectionBuilder::addWritable(\Athens\Core\Writer\WritableInterface $writable)





* Visibility: **public**


#### Arguments
* $writable **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)**



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


