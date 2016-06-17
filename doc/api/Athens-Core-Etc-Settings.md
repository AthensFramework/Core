Athens\Core\Etc\Settings
===============

Class Settings is a static class for maintaining application-wide settings.




* Class name: Settings
* Namespace: Athens\Core\Etc







Methods
-------


### addTemplateTheme

    void Athens\Core\Etc\Settings::addTemplateTheme(string $theme)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $theme **string**



### addTemplateDirectory

    void Athens\Core\Etc\Settings::addTemplateDirectory(string $directory)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $directory **string**



### addProjectCSS

    void Athens\Core\Etc\Settings::addProjectCSS(string $file)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $file **string**



### addProjectJS

    void Athens\Core\Etc\Settings::addProjectJS(string $file)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $file **string**



### getTemplateDirectories

    array<mixed,string> Athens\Core\Etc\Settings::getTemplateDirectories()





* Visibility: **public**
* This method is **static**.




### setDefaultWriterClass

    void Athens\Core\Etc\Settings::setDefaultWriterClass(string $writerClass)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $writerClass **string**



### getDefaultWriterClass

    string Athens\Core\Etc\Settings::getDefaultWriterClass()





* Visibility: **public**
* This method is **static**.




### setDefaultEmailerClass

    void Athens\Core\Etc\Settings::setDefaultEmailerClass(string $emailerClass)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $emailerClass **string**



### getDefaultEmailerClass

    string Athens\Core\Etc\Settings::getDefaultEmailerClass()





* Visibility: **public**
* This method is **static**.




### setDefaultInitializerClass

    void Athens\Core\Etc\Settings::setDefaultInitializerClass(string $initializerClass)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $initializerClass **string**



### getDefaultInitializerClass

    string Athens\Core\Etc\Settings::getDefaultInitializerClass()





* Visibility: **public**
* This method is **static**.




### getProjectJS

    array<mixed,string> Athens\Core\Etc\Settings::getProjectJS()





* Visibility: **public**
* This method is **static**.




### getProjectCSS

    array<mixed,string> Athens\Core\Etc\Settings::getProjectCSS()





* Visibility: **public**
* This method is **static**.




### getDefaultPagination

    integer Athens\Core\Etc\Settings::getDefaultPagination()





* Visibility: **public**
* This method is **static**.




### setAcronyms

    void Athens\Core\Etc\Settings::setAcronyms(array<mixed,string> $acronyms)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $acronyms **array&lt;mixed,string&gt;**



### getAcronyms

    array<mixed,string> Athens\Core\Etc\Settings::getAcronyms()





* Visibility: **public**
* This method is **static**.




### setDefaultPagination

    void Athens\Core\Etc\Settings::setDefaultPagination(integer $value)





* Visibility: **public**
* This method is **static**.


#### Arguments
* $value **integer** - &lt;p&gt;The default number of rows per page to display, when paginating.&lt;/p&gt;


