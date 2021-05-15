<?php

namespace backend\persistence\extend\vo;

use core\database\BaseVo;

class CountryReportVo extends BaseVo {
	public $id;
	public $code;
	public $name;
	public $currencyCode;
	public $symbol;
	public $orderCount;
	public $paidAmount;
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
				'id' => 'id',
				'code' => 'code',
				'name' => 'name',
				'currency_code' => 'currencyCode',
				'order_count' => 'orderCount',
				'paid_amount' => 'paidAmount' 
		);
	}
}