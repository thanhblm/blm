<?php

namespace backend\persistence\extend\vo;

use core\database\BaseVo;

class OverviewReportVo extends BaseVo {
	public $regionId;
	public $orderStatusId;
	public $currencyCode;
	public $symbol;
	public $orderCount;
	public $orderTotal;
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
				'region_id' => 'regionId',
				'order_status_id' => 'orderStatusId',
				'currency_code' => 'currencyCode',
				'order_count' => 'orderCount',
				'order_total' => 'orderTotal' 
		);
	}
}