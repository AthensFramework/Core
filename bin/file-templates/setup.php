<?php
namespace SessionGlobals;

// Setup DOMPDF
define('DOMPDF_ENABLE_AUTOLOAD', false);
define('DOMPDF_ENABLE_REMOTE', true);

// setup the autoloading
require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/settings.php';

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use Athens\CSRF\CSRF;
use Athens\Core\Settings\Settings;
use Athens\Encryption\Cipher;

if (REPORT_ERRORS) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Initialize the session
session_start();

// Initialize CSRF Protection
CSRF::init();

// Setup Framework
Settings::getInstance()->addTemplateDirectories(dirname(__FILE__) ."/project-templates");
Settings::getInstance()->addAcronyms('ssn');
Cipher::createInstance(ATHENS_ENCRYPTION_PASSWORD);


// Setup Propel
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass(APPLICATION_NAME, 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array (
    'dsn'      => MYSQL_DSN,
    'user'     => MYSQL_USER,
    'password' => MYSQL_PASSWORD,
));
$serviceContainer->setConnectionManager(APPLICATION_NAME, $manager);

// Include project-specific CSS
$fullCSSFilesnames = glob(dirname(__FILE__) . "/project-assets/css/*.css");
$relativeCSSFilesnames = str_replace(dirname(__FILE__) . "/", "", $fullCSSFilesnames);
foreach ($relativeCSSFilesnames as $file) {
    Settings::getInstance()->addProjectCSS($file);
}

// Include project-specific JS
$fullJSFilesnames = glob(dirname(__FILE__) . "/project-assets/js/*.js");
$relativeJSFilesnames = str_replace(dirname(__FILE__) . "/", "", $fullJSFilesnames);
foreach ($relativeJSFilesnames as $file) {
    Settings::getInstance()->addProjectJS($file);
}

