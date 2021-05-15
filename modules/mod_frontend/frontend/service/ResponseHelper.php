<?php

namespace frontend\service;

use common\model\ResponseMo;
use common\config\ErrorCodes;
use core\utils\JsonUtil;

class ResponseHelper {
	public static function setSuccess(ResponseMo $response, $msg, $data = null) {
		$response->status = ErrorCodes::SUCCESS;
		$response->msg = $msg;
		$response->data = $data;
		return $response;
	}
	public static function setError(ResponseMo $response, $msg, $data = null) {
		$response->status = ErrorCodes::ERROR;
		$response->msg = $msg;
		$response->data = $data;
		return $response;
	}
	public static function getResponseJson(ResponseMo $response) {
		return JsonUtil::encode ( $response );
	}
	public static function isError(ResponseMo $response) {
		$isError = false;
		if ($response->status == ErrorCodes::ERROR) {
			$isError = true;
		}
		return $isError;
	}
}