<?php
require_once dirname(__FILE__) . '/local-settings.php';

define("APPLICATION_NAME", SET_ME);

define('MYSQL_DSN', 'mysql:host=' . MYSQL_HOST . ';port=' . MYSQL_PORT . ';dbname=' . MYSQL_DB_NAME);
