<?php

date_default_timezone_set(SET_ME);
// For University of Washington, use 'America/Los_Angeles', with quotes.

define('REPORT_ERRORS', SET_ME);
// Typically true for a development environment, or false for a production environment

define('MYSQL_HOST', '127.0.0.1');  // Edit if your MYSQL host is not on this server
define('MYSQL_PORT', '3306');       // '3306' is usually the correct value, but you may have to edit
define('MYSQL_DB_NAME', SET_ME);
define('MYSQL_USER', SET_ME);
define('MYSQL_PASSWORD', SET_ME);

define('UWDOEM_ENCRYPTION_PASSWORD', SET_UWDOEM_ENCRYPTION_PASSWORD);

define('MYSQL_DSN', 'mysql:host=' . MYSQL_HOST . ';port=' . MYSQL_PORT . ';dbname=' . MYSQL_DB_NAME);
