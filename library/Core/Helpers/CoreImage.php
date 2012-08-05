<?php
class Core_Helper_CoreImage extends Zend_View_Helper_Abstract
{
    
    /**
     * Returns HTML mage 
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
    public function CoreImage($src = '', array $options = array())
    {
        $attribs = '';
        if (count($options)){
            foreach ($options as $attrib => $value){
                $attribs .= trim($attrib).'="'.trim($value).'" ';
            }
        }           
        return '<img src="http://'.DOMAIN.'/'.(($src) ? strip_tags(trim($src)) : '/').'" '.strip_tags($attribs).' />';
    }
}
?>