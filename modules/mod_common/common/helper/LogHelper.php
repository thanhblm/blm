<?php

namespace common\helper;

use common\utils\DateUtil;
use common\utils\FileUtil;
use core\config\ApplicationConfig;
use core\utils\AppUtil;
use frontend\service\CreditCardHelper;

class LogHelper {
	private static function getDebugFilePath() {
		$dirPath = AppUtil::defaultIfEmpty ( ApplicationConfig::get ( "debug.tmp.path" ) );
		return $dirPath;
	}
	public static function logRequest($type, $requestUrl, $requestData, $responseData) {
		$dateStr = DateUtil::getCurrentDT ();
		$requestData = self::clearRequestData ( $requestData );
		$responseData = self::clearRequestData ( $responseData );
		$fileContent = null;
		$fileContent .= "-------------------------------\n";
		$fileContent .= "Transaction Start: $dateStr\n";
		$fileContent .= "Request URL: $requestUrl\n";
		$fileContent .= "Request data:\n";
		$fileContent .= self::getData ( $requestData );
		$fileContent .= "Response data:\n";
		$fileContent .= self::getData ( $responseData );
		$filePath = self::getDebugFilePath () . date ( 'Ymd' ) . '_' . $type . '.log';
		\DatoLogUtil::trace ( $filePath );
		FileUtil::appendFile ( $filePath, $fileContent );
	}
	private static function clearRequestData($request) {
		if (is_array ( $request ) && count($request) > 0) {
			$request ['language'] = null;
			$request ['languages'] = null;
			$request ['region'] = null;
			$request ['regions'] = null;
		}
		return $request;
	}
	private static function getData($data) {
		// \DatoLogUtil::devInfo ( $data );
		if (is_array ( $data ) && isset ( $data ['x_Card_Code'] )) {
			$data ['x_Card_Code'] = CreditCardHelper::maskCCCode ( $data ['x_Card_Code'] );
		}
		\DatoLogUtil::debug ( $data );
		$dataStr = null;
		$dataStr = print_r ( $data, true );
		$dataStr = CreditCardHelper::maskCCNumberInContent ( $dataStr );
		// \DatoLogUtil::debug ( $dataStr );
		return $dataStr;
	}
}