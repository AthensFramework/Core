Application Deployment Tutorial
=============================

This tutorial is the first of three parts:

  1. [Application creation](application-creation.md)
  
  2. Application deployment
  
  3. [Application modification](application-modification.md)
  

Prerequisites
-------------

To complete this tutorial, you must first have:

  1. The code repository you created in [application creation](application-creation.md)
  
  2. A working production php web server environment
  
  3. Access to the command-line command `php`
  
  4. A production MySQL database which can be dedicated to this project, plus user credentials for a user with full privileges on that database

Steps
-----
  
  * Create a production project web root:
  
    See the instructions for creating a project web root in the [application creation tutorial](application-creation.md). The same instructions apply to creating a web root in your production environment.
    
    All of the example commands in this tutorial are issued from within your project web root. All files created are relative to your project web root.

  * Link to your repository and pull:
  
    The technical details of linking to your repository and pulling code down from it are beyond the scope of this tutorial.
  
  * Install Composer:
  
    If your production environment is on a *nix server, then you probably want to install Composer locally by entering:
    ```
    curl -sS https://getcomposer.org/installer | php
    ```
    
    You may refer to the instructions for installing Composer in the [application creation tutorial](application-creation.md) for other options.
  
  * Install project requirements:
  
    Now we tell composer to download our project's dependencies:
    ```
    php composer.phar install --no-dev
    ```

  * Create and edit local-settings.php:
  
    Recall that the `local-settings.php` file you created in your development environment *is not* under version control and thus was *not* created when you pulled your project down into your production environment. We can create a new `local-settings.php` file by entering the following command:
    ```
    php vendor/athens/core/bin/manage.php create-local-settings
    ```
    
    Now edit `local-settings.php` to reflect the settings for your production environment.

  * Build the database and objects:
  
    `cd` into `project-schema` and then issue the following commands:
      
    ```
    php ../vendor/propel/propel/bin/propel.php model:build;
    php ../vendor/propel/propel/bin/propel.php sql:build;
    php ../vendor/propel/propel/bin/propel.php sql:insert;
    ```
      
    Now `cd` back into your project web root and issue the following:
    ```
    php composer.phar dump-autoload
    ```

Problems?
---------

  That's it: you should now have a working production deployment. Try visiting `pages/enter-student.php`, or `admin/student-table.php` in your web browser.
  
  You might get some kind of *permission denied* error from the server when visiting your web pages. Assuming that you have a working Php web environment, a *permission denied* error would probably mean that you `.htaccess` files are incorrectly configured. Try editing the `pages/.htaccess` file or the `admin/.htaccess` file.
  
  For all other errors, try setting `REPORT_ERRORS` to `true` in your `local-settings.php`. Once you've fixed the problem, be sure to turn error reporting back off!
  

Next Steps
----------

  See the next step in this tutorial: [Application modification](application-modification.md).
