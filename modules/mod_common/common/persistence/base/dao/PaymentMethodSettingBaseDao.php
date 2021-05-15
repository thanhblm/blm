<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PaymentMethodSettingVo;
use common\persistence\base\mapping\PaymentMethodSettingMapping;

class PaymentMethodSettingBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeSelectOne ( PaymentMethodSettingMapping::class, 'selectByKey', $paymentMethodSettingVo );
		return $result;
	}
	final public function selectAll(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeSelectList ( PaymentMethodSettingMapping::class, 'selectAll', $paymentMethodSettingVo );
		return $result;
	}
	final public function selectByFilter(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeSelectList ( PaymentMethodSettingMapping::class, 'selectByFilter', $paymentMethodSettingVo );
		return $result;
	}
	final public function countByFilter(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeCount ( PaymentMethodSettingMapping::class, 'countByFilter', $paymentMethodSettingVo );
		return $result;
	}
	final public function insertDynamic(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeInsert ( PaymentMethodSettingMapping::class, 'insertDynamic', $paymentMethodSettingVo );
		return $result;
	}
	final public function updateDynamicByKey(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeUpdate ( PaymentMethodSettingMapping::class, 'updateDynamicByKey', $paymentMethodSettingVo );
		return $result;
	}
	final public function deleteByKey(PaymentMethodSettingVo $paymentMethodSettingVo = null) {
		$result = $this->executeDelete ( PaymentMethodSettingMapping::class, 'deleteByKey', $paymentMethodSettingVo );
		return $result;
	}
}

