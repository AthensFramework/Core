#!/usr/bin/env php
<?php

$arg = $argv[1];

switch ($arg) {
    case "init":
        require dirname(__FILE__) . "/init.php";
        break;
}