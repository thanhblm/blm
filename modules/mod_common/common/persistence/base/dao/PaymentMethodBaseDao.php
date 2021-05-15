<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PaymentMethodVo;
use common\persistence\base\mapping\PaymentMethodMapping;

class PaymentMethodBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeSelectOne ( PaymentMethodMapping::class, 'selectByKey', $paymentMethodVo );
		return $result;
	}
	final public function selectAll(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeSelectList ( PaymentMethodMapping::class, 'selectAll', $paymentMethodVo );
		return $result;
	}
	final public function selectByFilter(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeSelectList ( PaymentMethodMapping::class, 'selectByFilter', $paymentMethodVo );
		return $result;
	}
	final public function countByFilter(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeCount ( PaymentMethodMapping::class, 'countByFilter', $paymentMethodVo );
		return $result;
	}
	final public function insertDynamic(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeInsert ( PaymentMethodMapping::class, 'insertDynamic', $paymentMethodVo );
		return $result;
	}
	final public function insertDynamicWithId(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeInsert ( PaymentMethodMapping::class, 'insertDynamicWithId', $paymentMethodVo );
		return $result;
	}
	final public function updateDynamicByKey(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeUpdate ( PaymentMethodMapping::class, 'updateDynamicByKey', $paymentMethodVo );
		return $result;
	}
	final public function deleteByKey(PaymentMethodVo $paymentMethodVo = null) {
		$result = $this->executeDelete ( PaymentMethodMapping::class, 'deleteByKey', $paymentMethodVo );
		return $result;
	}
}

