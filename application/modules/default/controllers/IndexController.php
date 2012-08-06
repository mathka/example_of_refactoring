<?php
/**
 * Default application controller
 * 
 * @uses       Core_Controller_Action
 * @subpackage Default controller
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class IndexController extends Core_Controller_Action {
    
    /**
     * @return void
     */
    public function indexAction() {
    	$form = new Default_Form_Search();
    	$form->basicElements();
    	$this->view->form = $form;
    	$this->view->js = 'js/index.phtml';
    }
    
    /**
     * @return void
     */
    public function ajaxlistAction() {
        $this->renderViewResults();
    }
    
    /**
     * @return void
     */
    public function ajaxsearchAction() {
        $this->renderViewResults();
    }
    
    /**
     * @return void
     */
    private function renderViewResults() {        
        $col = $this->getColumn();
        $sort = $this->getSortBy();
        $page = $this->getPageNumber();
        $offset = $this->getOffset($page);
        $searchText = $this->getSearchText();
         
        // call chosen soap method
        $client = new Zend_Soap_Client(Zend_Registry::get('config')->{APPLICATION_ENV}->wsdl);        
        $result = $client->getSearch($searchText, $col, $sort, $offset, $this->_resultPerPage);
        
        //we don't want to render Layout and automatic view render
        $this->_helper->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        
        $filter = new Zend_Filter_Alpha(); 
        $this->view->search = $filter->filter($this->_getParam('search'));
        $this->view->col = $col;
        $this->view->sort = $sort;
        $this->view->page = $page;
        $this->view->count = $this->getNumberOfTotalPages($result);
        $this->view->result = $result['rows'];
        $this->view->js = 'js/search.phtml';
        
        //return HTML
        print $this->view->render('index/list.phtml');
    }
    
    /**
     * @return int
     */
    private function getColumn() {
        return (!$this->_hasParam('col') || $this->_getParam('col')== 1) ? 1 : 2;
    }
    
    /**
     * @return int
     */
    private function getSortBy() {
        return (!$this->_hasParam('sort') || !in_array($this->_getParam('sort'), array(1,2)) ? 1 : (int)$this->_getParam('sort'));
    }
    
    /**
     * @return int
     */
    private function getPageNumber() {
        return ($this->_hasParam('page') && (int)$this->_getParam('page')>1) ? (int)$this->_getParam('page') : 1;
    }
    
    /**
     * @param int $page
     * @return int
     */
    private function getOffset($page) {
        return (int)(($page - 1)*$this->_resultPerPage);
    }
    
    /**
     * @param array $result
     * @return int
     */
    private function getNumberOfTotalPages(array $result) {
        return round($result['count']/$this->_resultPerPage, 0);
    }
    
    /**
     * @return string
     */
    private function getSearchText() {
        return ($this->_hasParam('search') && trim($this->_getParam('search'))) ? trim($this->_getParam('search')) : '';
    }

}