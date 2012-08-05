<?php

/**
 * Class managment announcements about systems messages, warnings and errors
 *
 */
class Core_Messages{
	
    /**
     * messages array
     *
     * @var array
     */
	protected $_messages = array();
	
	/**
	 * warnings array
	 * 
	 * @var array
	 */
	protected $_warnings = array();
	
	/**
	 * errors array
	 *
	 * @var array
	 */
	protected $_errors 	= array();
	
	/**
	 * Core_Messages instance
	 * 
	 * @var Core_Messages
	 */
	protected static $_instance;
	
	/**
	 * Constructor
	 *
	 */
	public function __construct() 
	{}
	
	/**
	 * Singleton instance
	 * 
	 * @return Core_Messages
	 */
	public static function getInstance()
	{
	    if(!isset(self::$_instance)){
	        if(Zend_Session::namespaceIsset('Messages')){
	            $messages = new Zend_Session_Namespace('Messages');
	            self::$_instance = unserialize($messages->mess);
	            if(self::$_instance === false){
	                trigger_error('Some problems with unserializing session Messages namespace. Creating new!', E_USER_WARNING);
	                self::$_instance = new self();
	            }
	        }
	        else {
	            self::$_instance = new self();
	        }
	    }
	    return self::$_instance;
	}
	
	/**
	 * Initializes messages from form object
	 *
	 * @param Zend_Form $form
	 * @return void
	 * @access public
	 */
    public function initFromForm(Zend_Form $form) 
    {
        $messages = $form->getMessages();
        if(!empty($messages)){
            foreach($messages as $input => $inputMessages){
                foreach((array)$inputMessages as $msg){
                    $this->setError($msg);
                }
            }
        }
    }

    /**
     * Saves to session
     * 
     * @return void
     */    
    public function saveToSession()
    {
        $messages = new Zend_Session_Namespace('Messages');
        $messages->mess = serialize($this);
    }

    /**
     * Unsets all variables in namespace "Messages"
     * 
     * @return void
     */
    public function clear()
    {
        $this->_messages 	= array();
        $this->_warnings 	= array();
        $this->_errors 		= array();
        
        if(Zend_Session::namespaceIsset('Messages')) {
            $messages = new Zend_Session_Namespace('Messages');
            $messages->unsetAll();
        }
    }	

	/**
	 * Adds information about error
	 * 
	 * @param string $error
	 */
	public function setError($error)
	{
	    $markup = md5($error);
	    $this->_errors[$markup] = $error;
	    $this->saveToSession();
	}

	/**
	 * Adds warnings
	 * 
	 * @param string $warning
	 */
	public function setWarning($warning)
	{
	    $markup = md5($warning);
	    $this->_warnings[$markup] = $warning;
	    $this->saveToSession();
	}

	/**
	 * Adds messages from system
	 * 
	 * @param string $message
	 */
	public function setMessage($message)
	{
	    $markup = md5($message);
	    $this->_messages[$markup] = $message;
	    $this->saveToSession();
	}
	
	/**
	 * Reports on errors
	 *
	 * @return bool
	 */
	public function hasErrors()
	{
	    return !empty($this->_errors);
	}
	
	/**
	 * Reports on warnings
	 *
	 * @return bool
	 */
    public function hasWarnings()
    {
        return !empty($this->_warnings);
    }
	
    /**
     * Reports on messeges
     * 
     * @return bool
     */
    public function hasMessages()
    {
        return !empty($this->_messages);
    }
	
    /**
     * Gets warnings array
     * 
     * @return array
     */
    public function getWarnings()
    {
        return $this->_warnings;
    }
	
	/**
	 * Gets errors array
	 *
	 * @return array
	 */
	public function getErrors(){
		return $this->_errors;
	}
	
	/**
	 * Gets messages array
	 *
	 * @return array
	 */
	public function getMessages(){
		return $this->_messages;
	}
	
	/**
	 * Assign messages, warnings and errors to a template
	 * ERRORS, WARNINGS AND MESSAGES are assigned before will be parsed templates
	 *
	 */
    public function display(Zend_View $view)
    {
        $view->messages = $this->getMessages();
        $view->warnings = $this->getWarnings();
		$view->errors   = $this->getErrors();
		$view->notEmptyMessages = ($this->hasErrors() || $this->hasMessages() || $this->hasWarnings()) ? '1' : NULL;
		$this->clear();
	}
	
	
}
?>