<?php

/**
 * BaseDictionary
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $d_id
 * @property string $d_key
 * @property string $d_value
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 5845 2009-06-09 07:36:57Z jwage $
 */
abstract class BaseDictionary extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('dictionary');
        $this->hasColumn('d_id', 'integer', 4, array(
             'type' => 'integer',
             'unsigned' => '1',
             'primary' => true,
             'autoincrement' => true,
             'length' => '4',
             ));
        $this->hasColumn('d_key', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '50',
             ));
        $this->hasColumn('d_value', 'string', 50, array(
             'type' => 'string',
             'fixed' => 0,
             'primary' => false,
             'notnull' => true,
             'autoincrement' => false,
             'length' => '50',
             ));
    }

}