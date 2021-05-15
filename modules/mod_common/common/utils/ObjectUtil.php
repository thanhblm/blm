<?php

namespace common\utils;

use common\utils\DateUtil;
use core\database\BaseVo;
use core\Lang;
use core\utils\SessionUtil;
use frontend\common\Constants;

class ObjectUtil {
	public static function setCrMd($obj) {
		try {
			$loginVo = SessionUtil::get ( Constants::CUSTOMER_LOGIN_SESSION_NAME );
			if (! empty ( $loginVo ))
				$userId = $loginVo->userId;
			if (empty ( $userId ))
				$userId = SessionUtil::getId ();
			if (empty ( $obj->crBy )) {
				$obj->crBy = $userId;
				$obj->crDate = DateUtil::getCurrentDT ();
			}
			$obj->mdBy = $userId;
			$obj->mdDate = DateUtil::getCurrentDT ();
		} catch ( Exception $e ) {
			$msg = Lang::get ( '$obj is not an instance of BaseVo.' );
			\DatoLogUtil::error ( $e->getMessage () );
			\DatoLogUtil::debug ( $e );
		}
	}
}