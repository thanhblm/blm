<?php
use common\persistence\base\dao\PaymentTxnBaseDao;
use common\persistence\base\vo\PaymentTxnVo;
class PaymentTxnService extends BaseService {
	private $paymentTxnDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->paymentTxnDao = new PaymentTxnBaseDao ();
	}
	public function getPaymentTxnByKey(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->selectByKey ( $filter );
	}
	public function getPaymentTxnByFilter(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->selectByFilter ( $filter );
	}
	public function countPaymentTxnByFilter(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->countByFilter ( $filter );
	}
	public function addPaymentTxn(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->insertDynamic ( $filter );
	}
	public function updatePaymentTxn(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->updateDynamicByKey ( $filter );
	}
	public function deletePaymentTxn(PaymentTxnVo $filter) {
		return $this->paymentTxnDao->deleteByKey ( $filter );
	}
	public function getPaymentTxnVoByCartId($cartId) {
		$paymentTxnVo = new PaymentTxnVo ();
		$paymentTxnVo->cartInfoId = $cartId;
		$paymentTxnVos = $this->paymentTxnDao->selectByFilter ( $paymentTxnVo );
		if (! empty ( $paymentTxnVos ) && count ( $paymentTxnVos ) >= 1) {
			$paymentTxnVo = $paymentTxnVos [0];
		}
		return $paymentTxnVo;
	}
	public function getPaymentTxnVoByTxnId($txnId) {
		$paymentTxnVo = new PaymentTxnVo ();
		$paymentTxnVo->txnId = $txnId;
		$paymentTxnVos = $this->paymentTxnDao->selectByFilter ( $paymentTxnVo );
		if (! empty ( $paymentTxnVos ) && count ( $paymentTxnVos ) >= 1) {
			$paymentTxnVo = $paymentTxnVos [0];
		}
		return $paymentTxnVo;
	}
}