<?php

namespace frontend\service;

use common\config\Attributes;
use common\config\ErrorCodes;
use core\config\FErrorCodes;
use core\workflow\ContextBase;

class ErrorHelper {
	public static function getErrorMessage(ContextBase $context, $customMessage) {
		$errorCode = $context->get ( Attributes::ATTR_ERROR_CODE );
		$errorMessage = null;
		if (FErrorCodes::ERR_SYSTEM_INTERNAL_ERROR === $errorCode) {
			$errorMessage = $customMessage;
		} elseif (ErrorCodes::ERROR === $errorCode) {
			$errorMessage = $context->get ( Attributes::ATTR_ERROR_MESSAGE );
		}
		return array (
				Attributes::ATTR_ERROR_CODE => $errorCode,
				Attributes::ATTR_ERROR_MESSAGE => $errorMessage 
		);
	}
	public static function throwExceptionWhenError(ContextBase $context, $customMessage) {
		$errorCode = $context->get ( Attributes::ATTR_ERROR_CODE );
		if (FErrorCodes::ERR_SYSTEM_INTERNAL_ERROR === $errorCode) {
			throw new \Exception ( $customMessage );
		} elseif (ErrorCodes::ERROR === $errorCode) {
			throw new \Exception ( $context->get ( Attributes::ATTR_ERROR_MESSAGE ) );
		}
	}
}