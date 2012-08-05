<?php

// Set the initial include_path. 
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/../library'),
    get_include_path(),
)));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment (first it was defined in .htaccess)
defined('APPLICATION_ENV')  || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Define path to configs directory
define('CONFIG_PATH', realpath(dirname(__FILE__) . '/../configs'));

// Zend_Application 
require_once 'Zend/Application.php';

// Create application, bootstrap, and run
$application = new Zend_Application( APPLICATION_ENV, CONFIG_PATH . '/config.ini');
$application->bootstrap()
			->run();