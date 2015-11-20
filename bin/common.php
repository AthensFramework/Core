<?php


/**
 * Creates a 16 byte encryption password, suitable for use with UWDOEM\Encryption
 *
 * @return string
 */
function makeEncryptionPassword() {
    $key = base64_encode(openssl_random_pseudo_bytes(16));
    return str_replace("'", "+", $key);
}

/**
 * Returns the base project directory.
 *
 * @return string
 */
function getBaseDirectory() {
    $thisDirectory = getcwd();

    $search = ["/vendor/uwdoem/framework/bin", "\\vendor\\uwdoem\\framework\\bin"];
    $replace = ["", ""];

    return str_replace($search, $replace, $thisDirectory);
}

/**
 * Retrieves the text of a file from the file-templates directory.
 *
 * @param string $fileName
 * @return string
 */
function getFileTemplate($fileName) {
    $templatePath = dirname(__FILE__) . "/file-templates";
    return file_get_contents($templatePath . "/" . $fileName);
}