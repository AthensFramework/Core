<?php

/* BEGIN FUNCTIONS AND CONSTANTS */

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

/**
 * Produces a word-wrapped comment block from the given, unwrapped text and block parameters.
 *
 * @param string $text the unwrapped text
 * @param int $lineLength the max length of each line in the comment block
 * @param string $blockPrefix the line which shall begin the comment block
 * @param string $blockSuffix the line which shall end the comment block
 * @param string $linePrefix the characters which shall begin each line of the comment block
 * @return string the comment block
 */
function commentBlock($text, $lineLength, $blockPrefix, $blockSuffix, $linePrefix = " ") {
    $wrappedText = " * " . wordwrap($text, $lineLength, "\n$linePrefix");

    return <<<EOT
$blockPrefix
$wrappedText
$blockSuffix
EOT;
}

/**
 * Creates a word-wrapped page-doc block from the given, unwrapped text.
 *
 * @param string $text
 * @return string
 */
function pageDocBlock($text) {
    return commentBlock($text, 70, "<?php\n/**", " */", " * ");
}

/**
 * Creates a word-wrapped css comment block from the given, unwrapped text.
 *
 * @param string $text
 * @return string
 */
function cssCommentBlock($text) {
    return commentBlock($text, 70, "/**", " */", " * ");
}

/**
 * Creates a word-wrapped js comment block from the given, unwrapped text.
 *
 * @param string $text
 * @return string
 */
function jsCommentBlock($text) {
    return commentBlock($text, 70, "/**", " */", " * ");
}
/* END FUNCTIONS AND CONSTANTS */

/* BEGIN NEW PROJECT CREATION */
$directories = [];
$filesContent = [];

$filesContent[".htaccess"] = "Deny from all";
$filesContent["README.md"] = getFileTemplate("README.md");
$filesContent["README.md"] = getFileTemplate("backup.sh");
$filesContent[".gitignore"] = getFileTemplate(".gitignore");
$filesContent["local-settings.php"] = str_replace("SET_UWDOEM_ENCRYPTION_PASSWORD", "'" . makeEncryptionPassword() . "'", getFileTemplate("local-settings.php"));
$filesContent["settings.php"] = getFileTemplate("settings.php");
$filesContent["setup.php"] = getFileTemplate("setup.php");

$directories[] = "admin";
$directories[] = "admin/ajax-pages";
$directories[] = "admin/ajax-actions";

$filesContent["admin/.htaccess"] = "Deny from all";
$filesContent["admin/notice.php"] = pageDocBlock("Place here any pages which you wish to restrict to privileged users. Edit your .htaccess appropriately!");
$filesContent["admin/ajax-actions/notice.php"] = pageDocBlock("Place here any actions which are accomplished by AJAX, and not displayed directly to the screen.");
$filesContent["admin/ajax-pages/notice.php"] = pageDocBlock("Place here any pages which are loaded to the screen via AJAX.");


$directories[] = "pages";
$directories[] = "pages/ajax-pages";
$directories[] = "pages/ajax-actions";

$filesContent["pages/.htaccess"] = "Deny from all";
$filesContent["pages/notice.php"] = pageDocBlock("Place here any pages which you wish to restrict to administrators. Edit your .htaccess appropriately!");
$filesContent["pages/ajax-actions/notice.php"] = pageDocBlock("Place here any actions which are accomplished by AJAX, and not displayed directly to the screen.");
$filesContent["pages/ajax-pages/notice.php"] = pageDocBlock("Place here any pages which are loaded to the screen via AJAX.");


$directories[] = "project-assets";
$directories[] = "project-assets/css";
$directories[] = "project-assets/js";

$filesContent["project-assets/.htaccess"] = "Allow from all";
$filesContent["project-assets/notice.php"] = pageDocBlock("Any .css files placed into the project-assets/css directory, or .js files placed into the project-assets/js directory, will be automatically loaded into the <head> of any non-AJAX template provided by Framework.");
$filesContent["project-assets/css/project.css"] = cssCommentBlock("Any .css files placed into the project-assets/css directory, including this .css file, will be automatically loaded into the <head> of any non-AJAX template provided by Framework.");
$filesContent["project-assets/js/project.js"] = jsCommentBlock("Any .js files placed into the project-assets/js directory, including this .js file, will be automatically loaded into the <head> of any non-AJAX template provided by Framework.");


$directories[] = "project-components";

$filesContent["project-components/notice.php"] = pageDocBlock("Place here any re-usable classes that you use to build your pages. These will be autoloaded on page load by setup.php.");


$directories[] = "project-docs";
$directories[] = "project-docs/api-docs";

$filesContent["project-docs/.htaccess"] = "Allow from all";
$filesContent["project-docs/api-docs/notice.php"] = pageDocBlock("Leave this directory empty. If you choose to build documentation via php-documentor, build it into this directory.");
$filesContent["project-docs/notice.php"] = pageDocBlock("Place here any narrative project documentation.");
$filesContent["project-docs/index.php"] = getFileTemplate("index.php");
$filesContent["project-docs/index.md"] = getFileTemplate("index.md");

$directories[] = "project-schema";
$directories[] = "project-schema/generated-classes";

$filesContent["project-schema/propel.inc"] = getFileTemplate("propel.inc");
$filesContent["project-schema/schema.xml"] = getFileTemplate("schema.xml");
$filesContent["project-schema/generated-classes/notice.php"] = pageDocBlock("Propel will place the classes it generates in this directory.");


$directories[] = "project-templates";

$filesContent["project-templates/notice.php"] = pageDocBlock("Place here any custom templates that are specific to your project.");


$directories[] = "project-tests";
$filesContent["project-tests/notice.php"] = pageDocBlock("Place here your software tests.");


foreach ($directories as $directory) {
    mkdir(getBaseDirectory() . "/". $directory);
}

foreach ($filesContent as $relativeFilePath => $content) {
    $file = fopen(getBaseDirectory() . "/" . $relativeFilePath, "w");
    fwrite($file, $content);
    fclose($file);
}


/* END NEW PROJECT CREATION */
