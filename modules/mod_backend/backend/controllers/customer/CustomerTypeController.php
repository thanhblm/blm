<?php

namespace backend\controllers\customer;

use common\persistence\base\vo\CustomerTypeVo;
use core\common\Paging;
use core\Lang;
use core\PagingController;
use core\utils\AppUtil;
use common\services\customer\CustomerTypeService;
use common\utils\StringUtil;

/**
 * *
 *
 * @author TANDT
 *        
 */
class CustomerTypeController extends PagingController {
	// Data request
	public $customerType;
	// Data response
	public $customerTypes;
	public $customerTypeList;
	//
	public $customerTypeSv;
	public function __construct() {
		parent::__construct ();
		$this->customerType = new CustomerTypeVo ();
		$this->customerTypeSv = new CustomerTypeService();
		$this->filter = new CustomerTypeVo ();
	}
	public function listView() {
		$this->getCustomerTypes ();
		return "success";
	}
	public function search() {
		$this->getCustomerTypes ();
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
		$this->customerTypeSv->createCustomerType( $this->customerType );
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
		$this->customerTypeSv->updateCustomerType( $this->customerType );
		return "success";
	}
	public function delView() {
		$this->detail ();
		return "success";
	}
	public function del() {
		$this->customerTypeSv->deleteCustomerType($this->customerType );
		return "success";
	}
	private function validData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new CustomerTypeVo ();
			$filter->name = $this->customerType->name;
			$voResult = $this->customerTypeSv->selectByFilter ( $filter );
			if (count ( $voResult ) > 0 ) {
				$this->addFieldError ( "customerType[name]", Lang::getWithFormat ( "{0} has already existed!", $this->customerType->name ) );
			}
		}
	}
	private function validEditData() {
		$this->validForm ();
		if (! $this->hasErrors ()) {
			$filter = new CustomerTypeVo ();
			$filter->name = $this->customerType->name;
			$voResult = $this->customerTypeSv->selectByFilter ( $filter );
			
			$filterOld = new CustomerTypeVo ();
			$filterOld->id = $this->customerType->id;
			$voOldResult = $this->customerTypeSv->selectByFilter ( $filterOld );
			
			if ($voOldResult [0]->name != $this->customerType->name && count ( $voResult ) > 0) {
				$this->addFieldError ( "customerType[name]", Lang::getWithFormat ( "{0} has already existed!", $this->customerType->name ) );
			}
		}
	}
	private function validForm() {
		if (AppUtil::isEmptyString ( $this->customerType->name )) {
			$this->addFieldError ( "customerType[name]", Lang::get ( "Name can not be empty" ) );
		}
	}
	private function detail() {
		if (AppUtil::isEmptyString ( $this->customerType->id )) {
			$this->addFieldError ( "customerType[id]", Lang::get ( "ID not valid." ) );
		} else {
			$this->customerType = $this->customerTypeSv->selectBykey ( $this->customerType );
		}
	}
	private function getCustomerTypes() {
		$filter = $this->buildFilter ();
		$count = $this->customerTypeSv->searchCount ( $filter );
		$paging = new Paging ( $count, $this->pageSize, $this->getNLinks (), $this->page );
		$filter->start_record = $paging->startRecord - 1;
		$filter->end_record = $paging->pageSize;
		$this->customerTypes = $this->customerTypeSv->search ( $filter );
		$paging->records = $this->customerTypes;
		$this->customerTypeList = $paging;
	}
	private function buildFilter() {
		$filter = $this->buildBaseFilter ();
		StringUtil::clearObject ( $filter );
		return $filter;
	}
}