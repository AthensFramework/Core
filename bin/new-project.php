<?php

$baseDirectory = getcwd();

echo $baseDirectory;

$search = ["vendor/uwdoem/framework/bin", "vendor\\uwdoem\\framework\\bin"];
$replace = ["", ""];

$baseDirectory = str_replace($search, $replace, $baseDirectory);

echo $baseDirectory;
