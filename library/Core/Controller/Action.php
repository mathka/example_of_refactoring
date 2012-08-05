<?php
/**
 * Extension Zend_Controller_Action
 * Sets necessary method in all actions
 *
 * @uses 	   Zend_Controller_Action
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class Core_Controller_Action extends Zend_Controller_Action
{

	/**
	 * Amount of rows presents in array of results
	 * 
	 * var integer
	 */
	protected $_resultPerPage = 15;
	
	/**
	 * User messages interface 
	 *
	 * @var Core_Messages
	 */
	protected $_messages;
    
	/**
	 * Calls before runs action, but after init() function
	 *
	 */
    public function preDispatch()
    {
    	
        //gets configuration from registry
        $config = Zend_Registry::get('config');

        //sets system of messeges
        $this->_messages = Core_Messages::getInstance();

        //sets variable in view 
        $this->view->title = 'Sample code dictionary';
    }
    
    /**
     * Returns part url without domain name
     *
     * @return string
     */
    protected function _getCurrentUrl() 
    {
    	return $_SERVER['REQUEST_URI'];
    }
    
    /**
     * Sets variable to namespace 'Stack' in session
     *
     * @param string $var_name Name variable in name space
     * @param mixed $var
     * 
     * @return mixed $var
     */
    public function _setVarToStack($var_name, $var) 
    {
        if ($var_name) {
            $stack = new Zend_Session_Namespace('Stack');            
            $stack->$var_name = serialize($var);
        }
        return $var;
    }    
    
    /**
     * Returns variable from namespace 'Stack' in session
     *
     * @param string $var_name
     * @return mixed or FALSE, if chosen variable not exist
     */
    public function _getVarFromStack($var_name)
	{
	    if ($var_name){
	        if(Zend_Session::namespaceIsset('Stack')){
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? unserialize($stack->$var_name) : FALSE;
            }
	    }
	    return FALSE;
    }
    
    /**
     * Returns information chosen variable exisis in session
     *
     * @param string $var_name
     * @return bool
     */
    public function _hasVarFromStack($var_name)
	{
	    if ($var_name){
	        if(Zend_Session::namespaceIsset('Stack')){
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? TRUE : FALSE;
            }
	    }
	    return FALSE;
    }
    
	/**
     * Deletes variable from namespace 'Stack' in session 
     *
     * @param string $var_name
     * @return mixed or FALSE, if chosen variable not exist
     */
    public function _deleteVarFromStack($var_name)
	{
	    if ($var_name){
	        if(Zend_Session::namespaceIsset('Stack')){
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? $stack->__unset($var_name) : FALSE;
            }
	    }
	    return FALSE;
    }
	
    /**
     * Calls chosen function after execute command from action, before displays result on screen
     * 
     * @return void
     */
    public function postDispatch()
    {
        $this->_messages->display($this->view);
    }
}