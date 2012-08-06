<?php
require_once '/../library/Zend/Paginator/Adapter/Interface.php';

/**
 * Doctrine Adapter for Zend_Paginator
 */
class Core_Paginator_Adapter_Doctrine implements Zend_Paginator_Adapter_Interface {
    /**
     * Name of the row count column
     *
     * @var string
     */
    const ROW_COUNT_COLUMN = 'zend_paginator_row_count';

    /**
     * Database query
     *
     * @var Doctrine_Query
     */
    protected $_query = null;

    /**
     * Total item count
     *
     * @var integer
     */
    protected $_rowCount = null;

    /**
     * Constructor.
     *
     * @param Doctrine_Query $query The select query
     */
    public function __construct(Doctrine_Query $query) {
        $this->_query = $query;
    }

    /**
     * Sets the total row count, either directly or through a supplied query.
     *
     * @param  Doctrine_Query|integer $totalRowCount Total row count integer 
     *                                               or query
     * @return Zend_Paginator_Adapter_Doctrine_Query $this
     * @throws Zend_Paginator_Exception
     */
    public function setRowCount($rowCount) {}

    /**
     * Returns an array of items for a page.
     *
     * @param  integer $offset Page offset
     * @param  integer $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage) {
        return $this->_query->offset($offset)->limit($itemCountPerPage)->fetchArray();
    }

    /**
     * Returns the total number of rows in the result set.
     *
     * @return integer
     */
    public function count() {
        return $this->_query->count();
    }
}
?>