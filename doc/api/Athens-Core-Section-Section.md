Athens\Core\Section\Section
===============

A very general display element. May contain other writable elements.




* Class name: Section
* Namespace: Athens\Core\Section
* This class implements: [Athens\Core\Section\SectionInterface](Athens-Core-Section-SectionInterface.md)




Properties
----------


### $label

    protected string $label





* Visibility: **protected**


### $content

    protected string $content





* Visibility: **protected**


### $writables

    protected array<mixed,\Athens\Core\Writer\WritableInterface> $writables





* Visibility: **protected**


### $initFromPost

    protected callable $initFromPost





* Visibility: **protected**


### $initFromGet

    protected callable $initFromGet





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


### getType

    string Athens\Core\Section\SectionInterface::getType()





* Visibility: **public**
* This method is defined by [Athens\Core\Section\SectionInterface](Athens-Core-Section-SectionInterface.md)




### getWritables

    array<mixed,\Athens\Core\Section\SectionInterface> Athens\Core\Section\SectionInterface::getWritables()





* Visibility: **public**
* This method is defined by [Athens\Core\Section\SectionInterface](Athens-Core-Section-SectionInterface.md)




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



