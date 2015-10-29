<?php
namespace SessionGlobals;

// Setup DOMPDF
define('DOMPDF_ENABLE_AUTOLOAD', false);
define('DOMPDF_ENABLE_REMOTE', true);

// setup the autoloading
require_once dirname(__FILE__) . '/vendor/autoload.php';
require_once dirname(__FILE__) . '/settings.php';

define('MYSQL_DSN', 'mysql:host=' . MYSQL_HOST . ';port=' . MYSQL_PORT . ';dbname=' . MYSQL_DB_NAME);

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
use UWDOEM\CSRF\CSRF;
use UWDOEM\Framework\Etc\Settings;
use UWDOEM\Encryption\Cipher;

// Initialize the session
session_start();

// Initialize CSRF Protection
CSRF::init();

// Setup Framework
Settings::addTemplateTheme("UWBoundless2015");
Settings::addTemplateDirectory(dirname(__FILE__) ."/project-templates");
Cipher::createInstance(UWDOEM_ENCRYPTION_PASSWORD);


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
    Settings::addProjectCSS($file);
}

// Include project-specific JS
$fullJSFilesnames = glob(dirname(__FILE__) . "/project-assets/js/*.js");
$relativeJSFilesnames = str_replace(dirname(__FILE__) . "/", "", $fullJSFilesnames);
foreach ($relativeJSFilesnames as $file) {
    Settings::addProjectJS($file);
}

