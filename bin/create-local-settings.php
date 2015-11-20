<?php

require_once dirname(__FILE__) . "/common.php";

$content = str_replace("SET_UWDOEM_ENCRYPTION_PASSWORD", "'" . makeEncryptionPassword() . "'", getFileTemplate("local-settings.php"));

$file = fopen(getBaseDirectory() . "/local-settings.php", "w");
fwrite($file, $content);
fclose($file);