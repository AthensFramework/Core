Athens\Core\Field\FieldBuilder
===============

Class FieldBuilder




* Class name: FieldBuilder
* Namespace: Athens\Core\Field
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)







Methods
-------


### setRequired

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setRequired(boolean $required)





* Visibility: **public**


#### Arguments
* $required **boolean**



### setFieldSize

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setFieldSize(integer $fieldSize)





* Visibility: **public**


#### Arguments
* $fieldSize **integer**



### setType

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### setLabel

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setLabel(string $label)





* Visibility: **public**


#### Arguments
* $label **string**



### setInitial

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setInitial(string|array<mixed,string> $initial)





* Visibility: **public**


#### Arguments
* $initial **string|array&lt;mixed,string&gt;**



### setChoices

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setChoices(array<mixed,string> $choices)





* Visibility: **public**


#### Arguments
* $choices **array&lt;mixed,string&gt;**



### setHelptext

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setHelptext(string $helptext)





* Visibility: **public**


#### Arguments
* $helptext **string**



### setPlaceholder

    \Athens\Core\Field\FieldBuilder Athens\Core\Field\FieldBuilder::setPlaceholder(string $placeholder)





* Visibility: **public**


#### Arguments
* $placeholder **string**



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


