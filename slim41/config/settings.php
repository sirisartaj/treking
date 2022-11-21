<?php

// Error reporting for production
error_reporting(1);
ini_set('display_errors', '1');

// Timezone
date_default_timezone_set('Asia/Kolkata');

//CONSTANTS
$_SESSION['uid']='1';
$session_uid=$_SESSION['uid'];
define("SITE_KEY", "RestFul");
define("DB_PREFIX", "sg_");
define('UPLOADFILEPATH', $_SERVER['DOCUMENT_ROOT'] . '/slim4/public/uploads/');
define('UPLOADPATH', $_SERVER['DOCUMENT_ROOT'] .'/slim4/public/uploads/');
define("SITEURL", "http://" . $_SERVER['HTTP_HOST'] . '/slim4/public/');
define('UPLOADURL', SITEURL.'public/uploads/');
define('CONTROLLERPATH', 'Controllers/');
define("DBPREFIX", "sg");

//Error codes
define('ERR_OK', 200);//ok
define('ERR_NO_DATA', 204);//No Data found
define('ERR_EXISTS', 208);//Already Exist
define('ERR_NON_AUTH', 203);//Non-Authoritative
define('ERR_PARTIAL_CONT', 206);//Partial Content(required)
define('ERR_NOT_MODIFIED', 304);//Not Modified

define('BASE', "C:\Apache24\htdocs");
define("ADMIN_EMAIL","");
define("ADMIN_PHONE","+");
define("CERTIFICATIONS",array(SITEURL.'public/templates/images/certification_new.jpeg',SITEURL.'public/templates/images/certification_new2.jpeg'));

define("EXCELPATH", $_SERVER['DOCUMENT_ROOT'] . '/src/Utilities/PHPExcel_1.7.9_doc/Classes/');
// Settings
$settings = [];

// Path settings
$settings['root'] = dirname(__DIR__);
$settings['temp'] = $settings['root'] . '/tmp';
$settings['public'] = $settings['root'] . '/public';

// Error Handling Middleware settings
$settings['error'] = [
    // Should be set to false in production
    'display_error_details' => true,
    // Parameter is passed to the default ErrorHandler
    // View in rendered output by enabling the "displayErrorDetails" setting.
    // For the console and unit tests we also disable it
    'log_errors' => true,
    // Display error details in error log
    'log_error_details' => true,
];
$settings['db'] = [
    'driver' => 'mysql',
    'host' => 'localhost',
    'username' => 'root',
    'database' => 'tatva_newlive',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'flags' => [
        // Turn off persistent connections
        PDO::ATTR_PERSISTENT => false,
        // Enable exceptions
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,//ERRMODE_SILENT
        // Emulate prepared statements
        PDO::ATTR_EMULATE_PREPARES => true,
        // Set default fetch mode to array
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        // Set character set
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci'
    ],
];
return $settings;