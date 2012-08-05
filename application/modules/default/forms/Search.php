<?php

/**
 * Contact form for default module
 *
 * @uses       Core_Form
 * @package    Default
 * @subpackage Form
 * @author     Monika Czernicka <monika.czernicka@gmail.com>
 */
class Default_Form_Search extends Zend_Form
{    
    /**
     * Sets form elements
     * Doesn't use init() function, because is necessary set class for form tag
     *
     * @return void
     */    
    public function basicElements()
    {
        // set method     
        $this->setMethod('post');
        
        //Add a title element
        $this->addElement('text', 'search', array(
            'required' => true,
            'filters' => array('StringTrim', 'Alpha'),
            'validators' => array('Alpha')
        ));
                
        // Add the submit button
        $this->addElement('submit', 'send', array(
            'ignore' => true,
            'label' => 'Szukaj',
        ));
    }
}