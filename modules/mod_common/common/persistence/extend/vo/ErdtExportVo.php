<?php

namespace common\persistence\extend\vo;


use common\persistence\base\vo\OrderVo;

class ErdtExportVo extends OrderExtendVo {
	public function __construct(){
		parent::__construct();
		$this->resultMap ['ship_name'] = "shipName";
		$this->resultMap ['billName'] = "billName";
		$this->resultMap ['order_date'] = "orderDate";
		$this->resultMap ['ship_country_name'] = "shipCountryName";
		$this->resultMap ['bill_country_name'] = "billCountryName";
		$this->resultMap ['product_id'] = "productId";
		$this->resultMap ['product_quantity'] = "productQuantity";
		$this->resultMap ['base_price'] = "basePrice";
	}

	public $billName;
	public $shipName;
	public $orderDate;
	public $shipCountryName;
	public $billCountryName;
	public $productQuantity;
	public $productId;
	public $basePrice;
}