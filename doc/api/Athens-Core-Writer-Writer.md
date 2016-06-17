Athens\Core\Writer\Writer
===============

Class Writer is a visitor which renders Writable elements.




* Class name: Writer
* Namespace: Athens\Core\Writer
* Parent class: [Athens\Core\Visitor\Visitor](Athens-Core-Visitor-Visitor.md)





Properties
----------


### $environment

    protected \Twig_Environment $environment





* Visibility: **protected**


Methods
-------


### getTemplatesDirectories

    array<mixed,string> Athens\Core\Writer\Writer::getTemplatesDirectories()





* Visibility: **protected**




### write

    string Athens\Core\Writer\Writer::write(\Athens\Core\Writer\WritableInterface $host)

Visit a writable host and render it into html.



* Visibility: **protected**


#### Arguments
* $host **[Athens\Core\Writer\WritableInterface](Athens-Core-Writer-WritableInterface.md)**



### getEnvironment

    \Twig_Environment Athens\Core\Writer\Writer::getEnvironment()

Get this Writer's Twig_Environment; create if it doesn't exist;



* Visibility: **protected**




### loadTemplate

    \Twig_TemplateInterface Athens\Core\Writer\Writer::loadTemplate(string $subpath)

Find a template by path from within the registered template directories.

Ex: `loadTemplate("page/full_header.twig");`

* Visibility: **protected**


#### Arguments
* $subpath **string**



### visitSection

    string Athens\Core\Writer\Writer::visitSection(\Athens\Core\Section\SectionInterface $section)

Render $section into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $section **[Athens\Core\Section\SectionInterface](Athens-Core-Section-SectionInterface.md)**



### visitPage

    string Athens\Core\Writer\Writer::visitPage(\Athens\Core\Page\PageInterface $page)

Render $page into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $page **[Athens\Core\Page\PageInterface](Athens-Core-Page-PageInterface.md)**



### visitField

    string Athens\Core\Writer\Writer::visitField(\Athens\Core\Field\FieldInterface $field)

Render $field into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $field **[Athens\Core\Field\FieldInterface](Athens-Core-Field-FieldInterface.md)**



### visitRow

    string Athens\Core\Writer\Writer::visitRow(\Athens\Core\Row\RowInterface $row)

Render $row into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $row **[Athens\Core\Row\RowInterface](Athens-Core-Row-RowInterface.md)**



### visitTable

    string Athens\Core\Writer\Writer::visitTable(\Athens\Core\Table\TableInterface $table)

Render $table into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $table **[Athens\Core\Table\TableInterface](Athens-Core-Table-TableInterface.md)**



### visitForm

    string Athens\Core\Writer\Writer::visitForm(\Athens\Core\Form\FormInterface $form)

Render FormInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $form **[Athens\Core\Form\FormInterface](Athens-Core-Form-FormInterface.md)**



### visitFormAction

    string Athens\Core\Writer\Writer::visitFormAction(\Athens\Core\Form\FormAction\FormActionInterface $formAction)

Render FormActionInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $formAction **[Athens\Core\Form\FormAction\FormActionInterface](Athens-Core-Form-FormAction-FormActionInterface.md)**



### visitPickA

    string Athens\Core\Writer\Writer::visitPickA(\Athens\Core\PickA\PickAInterface $pickA)

Render PickAInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $pickA **[Athens\Core\PickA\PickAInterface](Athens-Core-PickA-PickAInterface.md)**



### visitPickAForm

    string Athens\Core\Writer\Writer::visitPickAForm(\Athens\Core\PickA\PickAFormInterface $pickAForm)

Render PickAFormInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $pickAForm **[Athens\Core\PickA\PickAFormInterface](Athens-Core-PickA-PickAFormInterface.md)**



### visitTableForm

    string Athens\Core\Writer\Writer::visitTableForm(\Athens\Core\Table\TableFormInterface $tableForm)

Render TableFormInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $tableForm **[Athens\Core\Table\TableFormInterface](Athens-Core-Table-TableFormInterface.md)**



### visitPaginationFilter

    string Athens\Core\Writer\Writer::visitPaginationFilter(\Athens\Core\Filter\PaginationFilter $filter)

Render a PaginationFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\PaginationFilter](Athens-Core-Filter-PaginationFilter.md)**



### visitSortFilter

    string Athens\Core\Writer\Writer::visitSortFilter(\Athens\Core\Filter\SortFilter $filter)

Render a SortFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\SortFilter](Athens-Core-Filter-SortFilter.md)**



### visitSearchFilter

    string Athens\Core\Writer\Writer::visitSearchFilter(\Athens\Core\Filter\SearchFilter $filter)

Render a SearchFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\SearchFilter](Athens-Core-Filter-SearchFilter.md)**



### visitStaticFilter

    string Athens\Core\Writer\Writer::visitStaticFilter(\Athens\Core\Filter\FilterInterface $filter)

Render a StaticFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### visitSelectFilter

    string Athens\Core\Writer\Writer::visitSelectFilter(\Athens\Core\Filter\FilterInterface $filter)

Render a SelectFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### visitDummyFilter

    string Athens\Core\Writer\Writer::visitDummyFilter(\Athens\Core\Filter\FilterInterface $filter)

Render a DummyFilter into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### visitFilter

    string Athens\Core\Writer\Writer::visitFilter(\Athens\Core\Filter\FilterInterface $filter)

Render a FilterInterface into html.

This method is generally called via double-dispatch, as provided by Visitor\VisitableTrait.

* Visibility: **public**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**



### visitFilterOfType

    string Athens\Core\Writer\Writer::visitFilterOfType(\Athens\Core\Filter\FilterInterface $filter, string $type)

Helper method to render a FilterInterface to html.



* Visibility: **protected**


#### Arguments
* $filter **[Athens\Core\Filter\FilterInterface](Athens-Core-Filter-FilterInterface.md)**
* $type **string**



### visitEmail

    string Athens\Core\Writer\Writer::visitEmail(\Athens\Core\Email\EmailInterface $email)

Render an email message into an email body, given its template.



* Visibility: **public**


#### Arguments
* $email **[Athens\Core\Email\EmailInterface](Athens-Core-Email-EmailInterface.md)**


