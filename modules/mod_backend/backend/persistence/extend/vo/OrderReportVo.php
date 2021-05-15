<?php

namespace backend\persistence\extend\vo;

use common\persistence\base\vo\OrderVo;

class OrderReportVo extends OrderVo {
	public $orderStatusName;
	public $shippingStatusName;
	public $regionName;
	public $firstName;
	public $lastName;
	public $email;
	public $customerType;
	public $accountType;
	public $shippingTitle;
	public $shippingCountry;
	public $billingCountry;
	public $taxTitle;
	public $taxAmount;
	public $productAmount;
	public $discountAmount;
	public $couponAmount;
	public $shippingAmount;
	public $totalAmount;
	public $paidAmount;
	public function __construct() {
		parent::__construct ();
		$this->resultMap ['order_status_name'] = 'orderStatusName';
		$this->resultMap ['shipping_status_name'] = 'shippingStatusName';
		$this->resultMap ['region_name'] = 'regionName';
		$this->resultMap ['first_name'] = 'firstName';
		$this->resultMap ['last_name'] = 'lastName';
		$this->resultMap ['email'] = 'email';
		$this->resultMap ['customer_type'] = 'customerType';
		$this->resultMap ['account_type'] = 'accountType';
		$this->resultMap ['shipping_title'] = 'shippingTitle';
		$this->resultMap ['shipping_country'] = 'shippingCountry';
		$this->resultMap ['billing_country'] = 'billingCountry';
		$this->resultMap ['tax_title'] = 'taxTitle';
		$this->resultMap ['tax_amount'] = 'taxAmount';
		$this->resultMap ['product_amount'] = 'productAmount';
		$this->resultMap ['discount_amount'] = 'discountAmount';
		$this->resultMap ['coupon_amount'] = 'couponAmount';
		$this->resultMap ['shipping_amount'] = 'shippingAmount';
		$this->resultMap ['total_amount'] = 'totalAmount';
		$this->resultMap ['paid_amount'] = 'paidAmount';
	}
}