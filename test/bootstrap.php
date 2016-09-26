<?php

require_once dirname(__FILE__) ."/../vendor/autoload.php";

use Athens\Encryption\Cipher;
use Athens\Core\Settings\Settings;

Cipher::createInstance("my_secret_passphrase");

$settings = Settings::getInstance();

$settings->setDefaultObjectWrapperClass('Athens\Core\Test\Mock\MockObjectWrapper');
$settings->setDefaultQueryWrapperClass('Athens\Core\Test\Mock\MockQueryWrapper');

$_SERVER["REQUEST_URI"] = "http://example.com/";
