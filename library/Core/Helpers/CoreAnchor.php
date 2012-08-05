<?php
class Core_Helper_CoreAnchor extends Zend_View_Helper_Abstract
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
    public function CoreAnchor($url = '', $label = '', array $options = array())
    {
        $attribs = '';
        if (count($options)){
            foreach ($options as $attrib => $value){
                $attribs .= trim($attrib).'="'.trim($value).'" ';
            }
        }            
        return '<a href="'.(($url) ? strip_tags(trim($url)) : '#').'" '.strip_tags($attribs).'>'.(($label) ? trim($label) : '').'</a>';
    }
}
?>