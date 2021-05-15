<?php
use core\utils\JsonUtil;
use core\App;

include (ROOT . DS . 'core' . DS . 'libs' . DS . 'log4php/Logger.php');
class DatoLoggerPatternConverterFile extends \LoggerPatternConverterFile {
	public function convert(\LoggerLoggingEvent $event) {
		return basename ( parent::convert ( $event ) );
	}
}
class DatoLoggerLayoutPattern extends \LoggerLayoutPattern {
	public function __construct() {
		parent::__construct ();
		$this->converterMap ['f'] = 'DatoLoggerPatternConverterFile';
	}
}
\Logger::configure ( ROOT . DS . 'app' . DS . 'config' . DS . 'log4php.xml' );
class DatoLogUtil {
	public static function logElapedTime($message, $elapsedTime) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( "ELAPSED TIME" )->trace ( "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage . " | Processed time(ms): " . $elapsedTime );
	}
	public static function trace($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->trace ( "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function info($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->info (  "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function debug($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->debug (  "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function error($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->error (  "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function warn($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->warn (  "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function fatal($message, $exception = null, $logger = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
			$myMessage = $message;
			if (is_object ( $message ) || is_array ( $message )) {
				$myMessage = JsonUtil::encode ( $message );
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( $logger )->fatal (  "[".App::$vdatoProcessId."][" . $fileinfo . "] " . $myMessage, $exception );
	}
	public static function devInfo($message, $exception = null) {
		$backtrace = debug_backtrace ();
		$fileinfo = '';
		try {
			if (! empty ( $backtrace [0] ) && is_array ( $backtrace [0] )) {
				$fileName = $backtrace [0] ['file'];
				$fileName = empty ( $fileName ) ? "" : $fileName;
				$fileName = basename ( $fileName );
				$fileinfo = $fileName . ":" . $backtrace [0] ['line'];
			}
		} catch ( Exception $e ) {
		}
		\Logger::getLogger ( "DEVELOPMENT LOG" )->info ( "[".App::$vdatoProcessId."][" . $fileinfo . "] log content ----------------------------------- ");
		\Logger::getLogger ( "DEVELOPMENT LOG" )->info ($message, $exception );
	}
}