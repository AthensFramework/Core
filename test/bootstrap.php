<?php

require_once dirname(__FILE__) ."/../vendor/autoload.php";

use Athens\Core\Settings\Settings;

$settings = Settings::getInstance();

$settings->setDefaultObjectWrapperClass('Athens\Core\Test\Mock\MockObjectWrapper');
$settings->setDefaultQueryWrapperClass('Athens\Core\Test\Mock\MockQueryWrapper');

$_SERVER["REQUEST_URI"] = "http://example.com/";
