<?php
/**
 * Helper uses in view
 * 
 * Returns HTML image
 *
 * @uses       Zend_View_Helper_Abstract
 * @package    Automobile
 * @subpackage Helper
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class Core_Helper_View_CoreImage extends Zend_View_Helper_Abstract
{
    
    /**
     * Returns HTML image 
     * 
     * Gets options as array:
     * 'label' -> name anchor (string)
     * 'src' -> url anachor (string), you can use ZEND url helper
     * 'attribs' -> you can add thera all what you need: 
     * 				(string) $options['attribs'] = 'class="your_class" style="background:pink;"';
     * 				(array)  $options['attribs'] = array('class'=>'your_class',
     * 													 'style'=>'background:pink;');
     *
     * @param array $options
     * @return string
     */
    public function CoreImage($src = '', $options = '')
    {
        $attribs = '';
        if (is_array($options)){
            foreach ($options as $attrib => $value){
                $attribs .= $attrib.'="'.$value.'" ';
            }
        }
        else {
            $attribs = $options;
        }
        return '<img src="http://'.DOMAIN.'/'.(($src) ? strip_tags(trim($src)) : '/').'" '.strip_tags($attribs).' />';
    }
}
?>