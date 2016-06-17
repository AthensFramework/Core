Athens\Core\PickA\PickA
===============

Class PickA presents users with multiple sections which may be viewed
only one at a time.




* Class name: PickA
* Namespace: Athens\Core\PickA
* This class implements: [Athens\Core\PickA\PickAInterface](Athens-Core-PickA-PickAInterface.md)






Methods
-------


### __construct

    mixed Athens\Core\PickA\PickA::__construct(string $id, array<mixed,string> $classes, array<mixed,string> $data, array $manifest)





* Visibility: **public**


#### Arguments
* $id **string**
* $classes **array&lt;mixed,string&gt;**
* $data **array&lt;mixed,string&gt;**
* $manifest **array**



### getWritables

    array<mixed,\Athens\Core\Writer\WritableInterface> Athens\Core\PickA\PickAInterface::getWritables()





* Visibility: **public**
* This method is defined by [Athens\Core\PickA\PickAInterface](Athens-Core-PickA-PickAInterface.md)




### getLabels

    array<mixed,string> Athens\Core\PickA\PickAInterface::getLabels()





* Visibility: **public**
* This method is defined by [Athens\Core\PickA\PickAInterface](Athens-Core-PickA-PickAInterface.md)




### getManifest

    array Athens\Core\PickA\PickAInterface::getManifest()





* Visibility: **public**
* This method is defined by [Athens\Core\PickA\PickAInterface](Athens-Core-PickA-PickAInterface.md)




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



