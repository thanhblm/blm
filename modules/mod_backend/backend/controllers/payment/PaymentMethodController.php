<?php

namespace backend\controllers\payment;

use common\filter\payment\PaymentFilter;
use common\model\PaymentMethodMo;
use common\persistence\base\vo\PaymentMethodVo;
use common\services\payment\PaymentMethodService;
use core\common\Paging;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;

/**
 * *
 *
 * @author TANDT
 *        
 */
class PaymentMethodController extends PagingController {
	// Data request
	public $paymentMo;
	// Data response
	public $paymentVo;
	public $paymentVos;
	public $paymentList;
	//
	public $paymentSv;
	public function __construct() {
		parent::__construct ();
		$this->paymentVo = new PaymentMethodVo ();
		$this->paymentSv = new PaymentMethodService ();
		$this->paymentMo = new PaymentMethodMo ();
		$this->filter = new PaymentFilter ();
	}
	public function listView() {
		$this->getPaymentMethods ();
		return "success";
	}
	public function search() {
		$this->getPaymentMethods ();
		return "success";
	}
	public function addView() {
		return "success";
	}
	public function add() {
		$this->validData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->paymentVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->paymentVo->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->paymentVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->paymentVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->paymentSv->insert ( $this->paymentVo );
		$this->addActionMessage ( "The payment method added successfully" );
		return "success";
	}
	public function editView() {
		$this->detail ();
		return "success";
	}
	public function edit() {
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->paymentVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->paymentVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->paymentSv->update ( $this->paymentVo );
		$this->addActionMessage ( "The payment method updated successfully" );
		return "success";
	}
	public function copyView() {
		$this->detail ();
		return "success";
	}
	public function copy() {
		$this->validEditData ();
		if ($this->hasErrors ()) {
			return "success";
		}
		$this->preapareData ();
		$this->paymentVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->paymentVo->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->paymentVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->paymentVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->paymentSv->insert ( $this->paymentVo );
		$this->addActionMessage ( "The payment method cloned successfully" );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->paymentSv->delete ( $this->paymentMo );
		return "success";
	}
	private function preapareData() {
		AppUtil::copyProperties ( $this->paymentMo, $this->paymentVo );
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new PaymentMethodVo ();
			$filter->name = $this->paymentMo->name;
			$voResult = $this->paymentSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && $voResult [0]->name == $this->paymentMo->name) {
				$this->addFieldError ( "paymentMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->paymentMo->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new PaymentMethodVo ();
			$filter->name = $this->paymentMo->name;
			$voResult = $this->paymentSv->selectByFilter ( $filter );
			
			$filterOld = new PaymentMethodVo ();
			$filterOld->id = $this->paymentMo->id;
			$voOldResult = $this->paymentSv->selectByFilter ( $filterOld );
			
			if ($voOldResult [0]->name != $this->paymentMo->name) {
				if (count ( $voResult ) > 0 && $voResult [0]->name == $this->paymentMo->name) {
					$this->addFieldError ( "paymentMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->paymentMo->name ) );
				}
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->paymentMo->name )) {
			$this->addFieldError ( "paymentMo[name]", Lang::get ( "Name can not be empty" ) );
		}
		if (AppUtil::isEmptyString ( $this->paymentMo->status )) {
			$this->addFieldError ( "paymentMo[status]", Lang::get ( "Status is required" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->paymentMo->id )) {
			$this->addFieldError ( "paymentMo[id]", Lang::get ( "ID not valid." ) );
		} else {
			$this->paymentMo = $this->paymentSv->selectBykey ( $this->paymentMo );
		}
	}
	private function getPaymentMethods() {
		$filter = $this->buildFilter ();
		$count = $this->paymentSv->searchCount ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get lang list by filter.
		$this->paymentVos = $this->paymentSv->search ( $filter );
		$paging->records = $this->paymentVos;
		$this->paymentList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
}