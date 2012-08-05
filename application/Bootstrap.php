<?php
/**
 * Application bootstrap
 * 
 * @uses       Zend_Application_Bootstrap_Bootstrap
 * @subpackage Bootstrap
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    
   /**
     * Sets Zend_Registry
     *
     * @return void
     */
    protected function _initRegistry()
    {
        Zend_Registry::set('config', new Zend_Config_Ini(CONFIG_PATH . '/config.ini'));
        
        //Define constants at runtime
        defined('DOMAIN') || define('DOMAIN', Zend_Registry::get('config')->{APPLICATION_ENV}->domain);
        defined('DIR_PUBLIC') || define('DIR_PUBLIC', Zend_Registry::get('config')->{APPLICATION_ENV}->dir_public);
    }
	
	/**
	 * Initializes and sets attributes Doctrine + connects to database
	 *
	 * @return void
	 */
    protected function _initDoctrine()
    {
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
    }
    
    
    /**
     * Start Zend:Session
     *
     * @return void
     */
    protected function _initSession()
    {
        ob_start();
        Zend_Session::start();
    }   
    
    /**
     * Bootstrap autoloader for application resources
     * 
     * @return Zend_Application_Module_Autoloader
     */
    protected function _initModulesAutoload()
    {
        $autoloader = array();
        $autoloader[] = new Zend_Application_Module_Autoloader(array(
            'namespace' => 'Default',
            'basePath'  => dirname(__FILE__).'/modules/default',
        ));
        
        return $autoloader;
    }
    
    /**
     * Registers plugins
     * 
     * @return void
     */
    protected function _initPlugins()
    {
        $front = Zend_Controller_Front::getInstance();
        $front->registerPlugin(new Plugin_Layout());
    }
    
    /**
     * Bootstrap the view doctype
     * 
     * @return void
     */
    protected function _initDoctype()
    {
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('XHTML1_STRICT');
        $view->setHelperPath('Core/Helpers/View', 'Core_Helper_View');
    }
    
    /**
     * Sets error handler
     *
     * @return void
     */
    protected function initErrorReporting()
    {
    	// errors reporting
    	set_error_handler('Core_Errors_Handler::handle');
    }

}
