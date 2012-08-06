<?php
/**
 * Class with method for Soap Server
 *
 */
class Core_Soap {    
    /**
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