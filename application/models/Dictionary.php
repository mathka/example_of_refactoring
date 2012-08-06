<?php
class Dictionary extends BaseDictionary {
    
    /**
	 * Returns array with amount rows satisfy the conditionan and that rows for chosen page
	 *
	 * @param string $text
	 * @param integer $col
	 * @param integer $sort
	 * @param integer $offset
	 * @param integer $resultPerPage
	 * @return array
	 */
	public function getSearching($text = '', $col = 1, $sort = 1, $offset = 0, $resultPerPage = 15){
        $params = $this->prepareParams($text, $col, $sort, $offset, $resultPerPage);
        
        $result = array();
        $result['rows'] = $this->getRows($params);        
        $result['count'] = $this->getTotalRowsNumber($params);
                                
        return $result;
    }
    
    
    /**
     * @param string $text
     * @param integer $col
     * @param integer $sort
     * @param integer $offset
     * @param integer $resultPerPage
     * @return array
     */
    private function prepareParams($text = '', $col = 1, $sort = 1, $offset = 0, $resultPerPage = 15) {
        $params = array(
            'text' => $text,
            'col' => $col,
            'sort' => $sort,
            'offset' => $offset,
            'resultPerPage' => $resultPerPage,
        );
        
        $params['order'] = $this->getOrder($params);
        
        return $params;
    }
    
    /**
     * @param array $params
     * string
     */
    private function getOrder(array $params) {
        $order = ($params['col'] == 1) ? 'd_key' : 'd_value';
        $order.= ($params['sort'] == 1) ? ' ASC' : ' DESC';
        return $order;
    }
    
    /**
     * @param array $params
     * @return mixed
     */
    private function getRows(array $params) {
        $query = Doctrine_Query::create()
                    ->select('d.d_key, d.d_value')
                    ->addFrom('Dictionary d')
                    ->orderBy($params['order'])
                    ->offset($params['offset'])
                    ->limit($params['resultPerPage']);

        $this->addWhereToQuery($params, $query);
                                
        return $query->fetchArray();
    }
    
    /**
     * @param array $params
     * @return int
     */
    private function getTotalRowsNumber(array $params) {        
        $query = Doctrine_Query::create()->select('COUNT(d.d_key) AS count')
                    ->addFrom('Dictionary d');

        $this->addWhereToQuery($params, $query);
        
        $result = $query->fetchArray();
        
        return isset($result[0]['count']) ? $result[0]['count'] : 0;
    }
    
    /**
     * @param array $params
     * @param Doctrine_Query $query
     */
    private function addWhereToQuery(array $params, $query) {
        if ($params['where']) {
            $query->where('d.d_key LIKE "%'.$text.'%"');
        }
    }
}