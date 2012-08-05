<?php
// Set the initial include_path. 
set_include_path(implode(PATH_SEPARATOR, array(realpath(dirname(__FILE__) . '/../library'), get_include_path() )));

// Define path to application directory
defined('APPLICATION_PATH') || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../application'));

// Define application environment (first it was defined in .htaccess)
defined('APPLICATION_ENV')  || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));

// Define path to configs directory
define('CONFIG_PATH', realpath(dirname(__FILE__) . '/../configs'));

require_once realpath(dirname(__FILE__).'/../library/Zend/Registry.php');
require_once realpath(dirname(__FILE__).'/../library/Zend/Config/Ini.php');
        
Zend_Registry::set('config', new Zend_Config_Ini(CONFIG_PATH . '/config.ini'));

// load Doctrine
require_once('Doctrine/Doctrine.php');
spl_autoload_register(array('Doctrine', 'autoload'));
      
$db = Zend_Registry::get('config')->{APPLICATION_ENV}->resources->db->basic;
$dsn = sprintf(
    '%s://%s:%s@%s/%s',
    strtolower($db->type),
    $db->username,
    $db->password,
    $db->host,
    $db->dbname
); 
      
Doctrine_Manager::getInstance()
    ->setAttribute( Doctrine::ATTR_MODEL_LOADING, Doctrine::MODEL_LOADING_CONSERVATIVE);
      
Doctrine_Manager::connection($dsn)
    ->setAttribute(Doctrine::ATTR_QUOTE_IDENTIFIER, true)
    ->setCharset('utf8');
  
define('MODELS_PATH', APPLICATION_PATH . '/models');
Doctrine::loadModels(MODELS_PATH);
      
// SOAP      

require_once realpath(dirname(__FILE__).'/../library/Zend/Soap/Server.php');
require_once realpath(dirname(__FILE__).'/../library/Zend/Soap/AutoDiscover.php');
require_once realpath(dirname(__FILE__).'/../library/Core/Soap.php');

require_once realpath(dirname(__FILE__).'/../library/Zend/Filter/Alpha.php');
            
$server = new Zend_Soap_Server(Zend_Registry::get('config')->{APPLICATION_ENV}->wsdl, array());
        
// Bind Class to Soap Server
$server->setClass('Core_Soap');        

// Bind already initialized object to Soap Server
$server->setObject(new Core_Soap());

if (isset($_GET['wsdl'])){
	$autodiscover = new Zend_Soap_AutoDiscover();
	$autodiscover->setClass('Core_Soap');
    $autodiscover->handle();
}
else {
$server->handle();
}