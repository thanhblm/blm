<?php

namespace frontend\service;

use common\persistence\base\dao\CustomerTypeBaseDao;
use common\persistence\base\vo\CustomerTypeVo;

class CustomerHelper {
	public static function getCustomerTypeVoById($id) {
		$custTypeDao = new CustomerTypeBaseDao ();
		$custTypeVo = new CustomerTypeVo ();
		$custTypeVo->id = $id;
		$custTypeVo = $custTypeDao->selectByKey ( $custTypeVo );
		return $custTypeVo;
	}
	public static function getCustomerTypeNameById($id) {
		$name = null;
		$custTypeVo = self::getCustomerTypeVoById ( $id );
		if (! empty ( $custTypeVo ))
			$name = $custTypeVo->name;
		return $name;
	}
}