<?php

namespace backend\controllers\shipping;

use common\filter\shipping\ShippingFilter;
use common\model\ShippingMethodMo;
use common\persistence\base\vo\ShippingMethodVo;
use common\services\shipping\ShippingMethodService;
use common\utils\StringUtil;
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
class ShippingMethodController extends PagingController {
	// Data request
	public $shippingMo;
	// Data response
	public $shippingVo;
	public $shippingVos;
	public $shippingList;
	//
	public $shippingSv;
	public function __construct() {
		parent::__construct ();
		$this->shippingVo = new ShippingMethodVo ();
		$this->shippingSv = new ShippingMethodService ();
		$this->shippingMo = new ShippingMethodMo ();
		$this->filter = new ShippingFilter ();
	}
	public function listView() {
		$this->getShippingMethods ();
		return "success";
	}
	public function search() {
		$this->getShippingMethods ();
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
		$this->shippingVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->shippingVo->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->shippingVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->shippingVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->shippingSv->insert ( $this->shippingVo );
		$this->addActionMessage ( "Shipping method added successfully" );
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
		$this->shippingVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->shippingVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->shippingSv->update ( $this->shippingVo );
		$this->addActionMessage ( "Shipping method updated successfully" );
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
		$this->shippingVo->crDate = date ( 'Y-m-d H:i:s' );
		$this->shippingVo->crBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->shippingVo->mdDate = date ( 'Y-m-d H:i:s' );
		$this->shippingVo->mdBy = empty ( $this->getUserInfo () ) ? 0 : $this->getUserInfo ()->userId;
		$this->shippingSv->insert ( $this->shippingVo );
		$this->addActionMessage ( "Shipping method cloned successfully" );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->shippingSv->delete ( $this->shippingMo );
		return "success";
	}
	private function preapareData() {
		AppUtil::copyProperties ( $this->shippingMo, $this->shippingVo );
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new ShippingMethodVo ();
			$filter->name = $this->shippingMo->name;
			$voResult = $this->shippingSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 && $voResult [0]->name == $this->shippingMo->name) {
				$this->addFieldError ( "shippingMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->shippingMo->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new ShippingMethodVo ();
			$filter->name = $this->shippingMo->name;
			$voResult = $this->shippingSv->selectByFilter ( $filter );
			
			$filterOld = new ShippingMethodVo ();
			$filterOld->id = $this->shippingMo->id;
			$voOldResult = $this->shippingSv->selectByFilter ( $filterOld );
			
			if ($voOldResult [0]->name != $this->shippingMo->name) {
				if (count ( $voResult ) > 0 && $voResult [0]->name == $this->shippingMo->name) {
					$this->addFieldError ( "shippingMo[name]", Lang::getWithFormat ( "{0} has already existed!", $this->shippingMo->name ) );
				}
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->shippingMo->name )) {
			$this->addFieldError ( "shippingMo[name]", Lang::get ( "Name can not be empty" ) );
		} elseif (! StringUtil::validName ( $this->shippingMo->name )) {
			$this->addFieldError ( "shippingMo[name]", Lang::get ( "Name can't using special character !" ) );
		}
		if (AppUtil::isEmptyString ( $this->shippingMo->status )) {
			$this->addFieldError ( "shippingMo[status]", Lang::get ( "Status is required" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->shippingMo->id )) {
			$this->addFieldError ( "shippingMo[id]", Lang::get ( "Invalid not valid." ) );
		} else {
			$this->shippingMo = $this->shippingSv->selectBykey ( $this->shippingMo );
		}
	}
	private function getShippingMethods() {
		$filter = $this->buildFilter ();
		$count = $this->shippingSv->searchCount ( $filter );
		// Create new paging object.
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		// Get lang list by filter.
		$this->shippingVos = $this->shippingSv->search ( $filter );
		$paging->records = $this->shippingVos;
		$this->shippingList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ( "id asc" );
		return $filter;
	}
}