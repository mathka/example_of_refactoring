<?php
/**
 * Helper uses in view
 * 
 * Returns HTML anchor, if it's necessary adds before var url $_SERVER['REQUEST_URI'] 
 *
 * @uses       Zend_View_Helper_Abstract
 * @package    Automobile
 * @subpackage Helper
 * @author 	   Monika Czernicka <monika.czernicka@gmail.com>
 */
class Core_Helper_View_CoreAdvAnchor extends Zend_View_Helper_Abstract
{
    
    /**
     * Returns HTML anchor 
     * 
     * Gets options as array:
     * 'label' -> name anchor (string)
     * 'url' -> url anachor (string), you can use ZEND url helper
     * 'attribs' -> you can add thera all what you need: 
     * 				(string) $options['attribs'] = 'class="your_class" style="background:pink;"';
     * 				(array)  $options['attribs'] = array('class'=>'your_class',
     * 													 'style'=>'background:pink;');
     *
     * @param array $options
     * @return string
     */
    public function CoreAdvAnchor($url = '', $label = '', $options = '')
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
        $url = strip_tags(trim($url));
        if ($url[0] != '#' ||  $url[0] != '/')
            $url = $_SERVER['REQUEST_URI'].$url;
        return '<a href="'.(($url) ? $url : '#').'" '.strip_tags($attribs).'>'.(($label) ? trim($label) : '').'</a>';
    }
}
?>