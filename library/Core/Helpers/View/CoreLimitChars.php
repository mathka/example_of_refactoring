<?php
/**
 * Helper uses in view
 * 
 * Limits a phrase to a given number of characters
 *
 * @uses       Zend_View_Helper_Abstract
 * @package    Automobile
 * @subpackage Helper
 * @copyright  Kohana Framework
 */
class Core_Helper_View_CoreLimitChars extends Zend_View_Helper_Abstract
{    
    /**
	 * Limits a phrase to a given number of characters.
	 *
	 * @param   string   phrase to limit characters of
	 * @param   integer  number of characters to limit to
	 * @param   string   end character or entity
	 * @param   boolean  enable or disable the preservation of words while limiting
	 * @return  string
	 */
	public static function CoreLimitChars($str, $limit = 100, $end_char = NULL, $preserve_words = FALSE)
	{
		$end_char = ($end_char === NULL) ? '&#8230;' : $end_char;

		$limit = (int) $limit;

//		if (trim($str) === '' OR utf8::strlen($str) <= $limit)
		if (trim($str) === '' OR strlen($str) <= $limit)
			return $str;

		if ($limit <= 0)
			return $end_char;

		if ($preserve_words == FALSE)
		{
//			return rtrim(utf8::substr($str, 0, $limit)).$end_char;
            return rtrim(substr($str, 0, $limit)).$end_char;
		}

		preg_match('/^.{'.($limit - 1).'}\S*/us', $str, $matches);

		return rtrim($matches[0]).(strlen($matches[0]) == strlen($str) ? '' : $end_char);
	}
}
?>