<?php
// Set the initial include_path. 
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(dirname(__FILE__) . '/../library'),
    get_include_path(),
)));
// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));    
// Define application environment (first it was defined in .htaccess)
defined('APPLICATION_ENV') || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));
// Define path to data directory
define('DATA_PATH', realpath(dirname(__FILE__) . '/../data'));

require_once('Zend/Config.php');
require_once('Zend/Config/Ini.php');

$config = new Zend_Config_Ini('../configs/config.ini');
$db = $config->{APPLICATION_ENV}->resources->db->basic;
$dsn = sprintf(
	'%s://%s:%s@%s/%s',
	strtolower($db->type),
	$db->username,
	$db->password,
	$db->host,
	$db->dbname
); 

$doctrine_config = array(
	'data_fixtures_path'  => DATA_PATH.'/fixtures',
	'migrations_path'     => DATA_PATH.'/migrations',
	'sql_path'            => DATA_PATH.'/sql',
	'yaml_schema_path'    => DATA_PATH.'/schema',
	'models_path'         => APPLICATION_PATH.'/models',
);
 
require_once('../library/Doctrine/Doctrine.php'); 
// Set the autoloader
spl_autoload_register(array('Doctrine', 'autoload'));

$manager = Doctrine_Manager::getInstance();
$manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);

// Load the Doctrine connection
$conn = Doctrine_Manager::connection($dsn);
$conn->setAttribute(Doctrine::ATTR_QUOTE_IDENTIFIER, true);
 
// And instantiate
$cli = new Doctrine_Cli($doctrine_config);
$cli->run($_SERVER['argv']);