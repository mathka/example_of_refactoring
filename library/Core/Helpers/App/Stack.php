<?php
/**
 * Save needed variable in namespace "Stack" in session
 *
 * @package    Helper
 * @author     Monika Czernicka <monika.czernicka@gmail.com>
 */
class Core_Helpers_App_Stack {
    /**
     * @param string $var_name Name variable in name space
     * @param mixed $var
     * @return mixed $var
     */
    public function setVarToStack($var_name, $var) {
        if ($var_name) {
            $stack = new Zend_Session_Namespace('Stack');            
            $stack->$var_name = serialize($var);
        }
        return $var;
    }    
    
    /**
     * @param string $var_name
     * @param mixed $return Value which should be return if needed variable won't be save in session  
     * @return mixed or FALSE, if chosen variable not exist
     */
    public function getVarFromStack($var_name, $return = FALSE) {
	    if ($var_name){
	        if(Zend_Session::namespaceIsset('Stack')){
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? unserialize($stack->$var_name) : FALSE;
            }
	    }
	    return $return ? $return : FALSE;
    }
    
    /**
     * @param string $var_name
     * @return bool
     */
    public function hasVarFromStack($var_name) {
	    if ($var_name) {
	        if (Zend_Session::namespaceIsset('Stack')) {
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? TRUE : FALSE;
            }
	    }
	    return FALSE;
    }
    
	/**
     * @param string $var_name
     * @return mixed or FALSE, if chosen variable not exist
     */
    public function deleteVarFromStack($var_name) {
	    if ($var_name) {
	        if (Zend_Session::namespaceIsset('Stack')) {
                $stack = new Zend_Session_Namespace('Stack');
                return $stack->__isset($var_name) ? $stack->__unset($var_name) : FALSE;
            }
	    }
	    return FALSE;
    }
}