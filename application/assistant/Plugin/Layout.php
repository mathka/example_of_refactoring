<?php  

require_once 'Zend/Controller/Plugin/Abstract.php';  

class Plugin_Layout extends Zend_Controller_Plugin_Abstract {
    
    /**
     * Sets desired layout path
     *
     * @param Zend_Controller_Request_Abstract $abstract
     */
    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $abstract) {
        //sets below how first _initStartMvc function if you what in this place use "setLayout"
        $layout = Zend_Layout::getMvcInstance();
        $layout->setLayoutPath(APPLICATION_PATH . '/modules/' . $abstract->getModuleName() . '/layouts/scripts');
    }
}



?>  