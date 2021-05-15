<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\OrderVo;

class OrderExtendVo extends OrderVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ['order_status_name'] = "orderStatusName";
		$this->resultMap ['customer_name'] = "customerName";
		$this->resultMap ['shipping_status_name'] = "shippingStatusName";
		$this->resultMap ['grand_total_amount'] = "grandTotalAmount";
		$this->resultMap ['bill_country'] = "billCountry";
		$this->resultMap ['ship_country'] = "shipCountry";
		$this->resultMap ['language_name'] = "languageName";
		$this->resultMap ['currency_symbol'] = "currencySymbol";
		$this->resultMap ['region_name'] = "regionName";
		$this->resultMap ['bill_state'] = "billState";
		$this->resultMap ['ship_state'] = "shipState";
		$this->resultMap ['ship_by'] = "shipBy";
		$this->resultMap ['payment_method_id'] = "paymentMethodId";
		$this->resultMap ['pending_hour'] = "pendingHour";
	}
	public $orderStatusName;
	public $shippingStatusName;
	public $dateFrom;
	public $dateTo;
	public $grandTotalAmount;
	public $grandTotalFrom;
	public $grandTotalTo;
	public $billCountry;
	public $shipCountry;
	public $languageName;
	public $currencyName;
	public $currencySymbol;
	public $isUSA;
	public $usaFilter;
	public $erdt;
	public $shipDate;
	public $shipBy;
	public $trackingCode;
	public $regionName;
	public $billState;
	public $shipState;
	public $orderTotal;
	public $startDate;
	public $paymentMethodId;
	public $pendingHour;
	public $refundAmount;
}