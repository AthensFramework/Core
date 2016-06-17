Athens\Core\PickA\PickAFormBuilder
===============

Class PickAFormBuilder




* Class name: PickAFormBuilder
* Namespace: Athens\Core\PickA
* Parent class: [Athens\Core\Etc\AbstractBuilder](Athens-Core-Etc-AbstractBuilder.md)





Properties
----------


### $type

    protected string $type = "base"





* Visibility: **protected**


### $method

    protected string $method = "post"





* Visibility: **protected**


### $target

    protected string $target = "_self"





* Visibility: **protected**


### $manifest

    protected array $manifest = array()





* Visibility: **protected**


### $actions

    protected array<mixed,\Athens\Core\Form\FormAction\FormActionInterface> $actions = array()





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


### setMethod

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::setMethod(string $method)





* Visibility: **public**


#### Arguments
* $method **string**



### setTarget

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::setTarget(string $target)





* Visibility: **public**


#### Arguments
* $target **string**



### addLabel

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::addLabel(string $label)





* Visibility: **public**


#### Arguments
* $label **string**



### addForms

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::addForms(array<mixed,\Athens\Core\Form\FormInterface> $forms)





* Visibility: **public**


#### Arguments
* $forms **array&lt;mixed,\Athens\Core\Form\FormInterface&gt;**



### setActions

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::setActions(array<mixed,\Athens\Core\Form\FormAction\FormActionInterface> $actions)





* Visibility: **public**


#### Arguments
* $actions **array&lt;mixed,\Athens\Core\Form\FormAction\FormActionInterface&gt;**



### setType

    \Athens\Core\PickA\PickAFormBuilder Athens\Core\PickA\PickAFormBuilder::setType(string $type)





* Visibility: **public**


#### Arguments
* $type **string**



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



