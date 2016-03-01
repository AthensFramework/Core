<?php

require_once dirname(__FILE__) ."/../vendor/autoload.php";

use Athens\Encryption\Cipher;

Cipher::createInstance("my_secret_passphrase");

$_SERVER["REQUEST_URI"] = "http://example.com/";
