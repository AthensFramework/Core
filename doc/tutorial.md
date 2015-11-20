Application Creation Tutorial
=============================

This tutorial is under construction.

Prerequisites
-------------

To complete this tutorial, you must first have:

  1. A working php web server environment
  
  2. Access to the command-line command `php`
  
  3. A MySQL database which can be dedicated to this project, plus user credentials for a user with full privileges on that database

Creating a New Project
----------------------
Create the directory `myproject`. Then `cd` into `myproject`.

Create the following `composer.json` inside `myproject/`:
```
{
  "require": {
    "propel/propel": "~2.0@dev",
    "uwdoem/framework": ">=0.1"
  },
  "require-dev": {
    "phpunit/phpunit": "4.5.*",
    "phpunit/phpunit-selenium": ">=1.2",
    "phpdocumentor/phpdocumentor": "2.7.*"
  },
  "autoload": {
    "classmap": [
      "project-schema/generated-classes/",
      "project-classes",
      "project-components",
      "project-templates"
    ]
  }
}

```

Install composer:
```
curl -sS https://getcomposer.org/installer | php
```

Initial install of requirements:
```
php composer.phar update --no-dev --no-autoloader
```

Initialize the project:
```
php vendor/uwdoem/framework/bin/manage.php init
```

Edit the file `local-settings.php` and replace all instances of `SET_ME`. All of the settings should be string literals, unless otherwise indicated.


Deploying an Existing Project
-----------------------------
