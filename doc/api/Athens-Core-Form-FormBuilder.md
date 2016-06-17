Athens\Core\Form\FormBuilder
===============

Class FormBuilder




* Class name: FormBuilder
* Namespace: Athens\Core\Form
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)







Methods
-------


### addLabel

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::addLabel(string $label)





* Visibility: **public**


#### Arguments
* $label **string**



### build

    mixed Athens\Core\Etc\AbstractBuilder::build()

Return the element under construction.

Returns an instance of the object type under construction.

* Visibility: **public**
* This method is **abstract**.
* This method is defined by [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)




### setType

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



### setActions

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setActions(array<mixed,\Athens\Core\Form\FormAction\FormAction> $actions)





* Visibility: **public**


#### Arguments
* $actions **array&lt;mixed,\Athens\Core\Form\FormAction\FormAction&gt;**



### setTarget

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setTarget(string $target)





* Visibility: **public**


#### Arguments
* $target **string**



### setMethod

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setMethod(string $method)





* Visibility: **public**


#### Arguments
* $method **string**



### setOnValidFunc

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setOnValidFunc(callable $onValidFunc)





* Visibility: **public**


#### Arguments
* $onValidFunc **callable**



### setOnInvalidFunc

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setOnInvalidFunc(callable $onInvalidFunc)





* Visibility: **public**


#### Arguments
* $onInvalidFunc **callable**



### setOnSuccessUrl

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::setOnSuccessUrl(string $onSuccessRedirect)





* Visibility: **public**


#### Arguments
* $onSuccessRedirect **string**



### addSubForms

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::addSubForms(array<mixed,\Athens\Core\Form\FormInterface> $subForms)





* Visibility: **public**


#### Arguments
* $subForms **array&lt;mixed,\Athens\Core\Form\FormInterface&gt;**



### addValidator

    \Athens\Core\Form\FormBuilder Athens\Core\Form\FormBuilder::addValidator(string $fieldName, callable $callable)





* Visibility: **public**


#### Arguments
* $fieldName **string**
* $callable **callable**



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


