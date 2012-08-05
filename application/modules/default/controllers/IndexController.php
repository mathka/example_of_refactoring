<?php
/**
 * Default application controller
 * 
 * @uses       Core_Controller_Action
 * @subpackage Default controller
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class IndexController extends Core_Controller_Action
{
    
    /**
     * Generates start page, rows of dictionary will be loaded with uses AJAX
     *
     * @return void
     */
    public function indexAction()
    {
    	$form = new Default_Form_Search();
    	$form->basicElements();
    	$this->view->form = $form;
    	$this->view->js = 'js/index.phtml';
    }
    
    /**
     * Generates array with rows of dictionary, enables sorting and paging
     *
     * @return void
     */
    public function ajaxlistAction(){
        
        //We don't want to render Layout and automatic view render
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $this->view->col = $col = (!$this->_hasParam('col') || $this->_getParam('col')== 1) ? 1 : 2;
        $this->view->sort = $sort = (!$this->_hasParam('sort') || !in_array($this->_getParam('sort'), array(1,2)) ? 1 : (int)$this->_getParam('sort'));
        $this->view->page = $page = ($this->_hasParam('page') && (int)$this->_getParam('page')>1) ? (int)$this->_getParam('page') : 1;
                        
        // sets offset - needed to paging
        $offset = (int)(($page - 1)*$this->_resultPerPage);
                
        // call soap method
        $client = new Zend_Soap_Client(Zend_Registry::get('config')->{APPLICATION_ENV}->wsdl);
        $result = $client->getList($col, $sort, $offset, $this->_resultPerPage);
        
        $this->view->count = round($result['count']/$this->_resultPerPage, 0);
        $this->view->result = $result['rows'];
        $this->view->js = 'js/list.phtml';
        
        // AJAX Will be return HTML
        print $this->view->render('index/list.phtml');
    }
    
    /**
     * Generates array with rows of dictionary which satisfying the condition, enables sorting and paging
     *
     * @return void
     */
    public function ajaxsearchAction(){        
        //We don't want to render Layout and automatic view render
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $this->view->col = $col = (!$this->_hasParam('col') || $this->_getParam('col')== 1) ? 1 : 2;
        $this->view->sort = $sort = (!$this->_hasParam('sort') || !in_array($this->_getParam('sort'), array(1,2)) ? 1 : (int)$this->_getParam('sort'));
        $this->view->page = $page = ($this->_hasParam('page') && (int)$this->_getParam('page')>1) ? (int)$this->_getParam('page') : 1;
        
        // sets offset - needed to pagination
        $offset = (int)(($page - 1)*$this->_resultPerPage);
        
        // call chosen soap method
        $client = new Zend_Soap_Client(Zend_Registry::get('config')->{APPLICATION_ENV}->wsdl);
        $result = ($this->_hasParam('search') && trim($this->_getParam('search'))) 
            ? $client->getSearch($this->_getParam('search'), $col, $sort, $offset, $this->_resultPerPage) 
            : $client->getList($col, $sort, $offset, $this->_resultPerPage);
        
        $filter = new Zend_Filter_Alpha(); 
        $this->view->search = $filter->filter($this->_getParam('search'));

        $this->view->count = round($result['count']/$this->_resultPerPage, 0);
        $this->view->result = $result['rows'];
        $this->view->js = 'js/search.phtml';
        
        // AJAX Will be return HTML
        print $this->view->render('index/list.phtml');
    }

}