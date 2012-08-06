<?php
class Core_Errors_Handler {
	static $translateErrorCodes = array(
		1		=> 'E_ERROR',
		2		=> 'E_WARNING',
		4		=> 'E_PARSE',
		8		=> 'E_NOTICE',
		16		=> 'E_CORE_ERROR',
		32		=> 'E_CORE_WARNING',
		64		=> 'E_COMPILE_ERROR',
		128		=> 'E_COMPILE_WARNING',
		256		=> 'E_USER_ERROR',
		512		=> 'E_USER_WARNING',
		1024	=> 'E_USER_NOTICE',
		6143	=> 'E_ALL',
		2048	=> 'E_STRICT',
		4096	=> 'E_RECOVERABLE_ERROR',
		8192	=> 'E_DEPRECATED',
		16384	=> 'E_USER_DEPRECATED'
	);

	static $developerEmail 	= 'monika.czernicka@gmail.com';

	static $logsPath = '../logs/';

	static $ignoreFilesErrors = array(
		'library/Zend/Autoloader.php'
	);
		
	static public function handle($errNo, $errStr, $errFile, $errContext) {
		//exclude ignored files
		if(!empty(self::$ignoreFilesErrors)){
			foreach(self::$ignoreFilesErrors as $val){
				if(substr_count($errFile, $val)){
					return false;
				}
			}
		}
		
		self::_saveToFile($errNo, $errStr, $errFile, $errContext);
		
		//emails disabled untill fixing soft
		self::_sendEMail($errNo, $errStr, $errFile, $errContext);
	}
	
	static private function _saveToFile($errNo, $errStr, $errFile, $errContext) {
		$outFile 	= rtrim(self::$logsPath, '/').'/'.date('Y-m-d').'.txt';
		$errorTxt 	= sprintf(
			'%s (%-15s) %s #%u: %s',
			date('H:i:s'),
			self::$translateErrorCodes[$errNo],
			$errFile,
			$errContext,
			$errStr
		);
		$pathInfo = pathinfo($outFile);
		if (!is_dir($pathInfo['dirname'])) {
			mkdir($pathInfo['dirname'], 0777, true);
		}	
		$fp = fopen($outFile, 'a');
		fwrite($fp, $errorTxt."\n");
		fclose($fp);
	}
	
	static private function _sendEMail($errNo, $errStr, $errFile, $errContext) {
		$errorTxt 	= sprintf(
		  '(%-15s) %s'."\n".'%s #%u:'."\n".'%s',
		  self::$translateErrorCodes[$errNo],
		  date('Y-m-d H:i:s'),
		  $errFile,
		  $errContext,
		  $errStr
		);
				
		$mail = new Zend_Mail('UTF-8');
	    $mail->setFrom('error@'.DOMAIN);
	    $mail->addTo(self::$developerEmail);
        $mail->setSubject('SYSTEM ERROR '.$_SERVER['REQUEST_URI']);
    	$mail->setBodyHtml($errorTxt);
        try {
        	$mail->send();
        } catch (Exception $e) {
        	self::_saveToFile(16, 'mail_error', __FILE__, $e);
        }
	}
}