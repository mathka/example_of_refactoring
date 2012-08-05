<?php
/**
 * Class with method for Soap Server
 *
 */
class Core_Soap {

	/**
	* This method takes a column id and kind of sort and return array of results
	 *
	 * @param integer $col
	 * @param integer $sort
	 * @param integer $page
	 * @param integer $resultPerPage
	 * @return array
	 */
    public function getList($col = 1, $sort = 1, $page = 1, $resultPerPage = 15) {
        
        $dictionary = new Dictionary();
        return $dictionary->getList($col, $sort, $page, $resultPerPage);
    }
    
    /**
     * Enter description here...
     *
     * @param string $text
     * @param integer $col
     * @param integer $sort
     * @param integer $page
     * @param integer $resultPerPage
     * @return array
     */
    public function getSearch($text = '', $col = 1, $sort = 1, $page = 1, $resultPerPage = 15) {
    	
    	$filter = new Zend_Filter_Alpha();
    	
        $dictionary = new Dictionary();
        return $dictionary->getSearching($filter->filter($text), $col, $sort, $page, $resultPerPage);
    }
}
?>