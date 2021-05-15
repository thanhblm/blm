<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\PaymentTxnVo;
use common\persistence\base\mapping\PaymentTxnMapping;

class PaymentTxnBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeSelectOne ( PaymentTxnMapping::class, 'selectByKey', $paymentTxnVo );
		return $result;
	}
	final public function selectAll(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeSelectList ( PaymentTxnMapping::class, 'selectAll', $paymentTxnVo );
		return $result;
	}
	final public function selectByFilter(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeSelectList ( PaymentTxnMapping::class, 'selectByFilter', $paymentTxnVo );
		return $result;
	}
	final public function countByFilter(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeCount ( PaymentTxnMapping::class, 'countByFilter', $paymentTxnVo );
		return $result;
	}
	final public function insertDynamic(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeInsert ( PaymentTxnMapping::class, 'insertDynamic', $paymentTxnVo );
		return $result;
	}
	final public function insertDynamicWithId(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeInsert ( PaymentTxnMapping::class, 'insertDynamicWithId', $paymentTxnVo );
		return $result;
	}
	final public function updateDynamicByKey(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeUpdate ( PaymentTxnMapping::class, 'updateDynamicByKey', $paymentTxnVo );
		return $result;
	}
	final public function deleteByKey(PaymentTxnVo $paymentTxnVo = null) {
		$result = $this->executeDelete ( PaymentTxnMapping::class, 'deleteByKey', $paymentTxnVo );
		return $result;
	}
}

