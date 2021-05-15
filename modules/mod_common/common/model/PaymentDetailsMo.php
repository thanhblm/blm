<?php

namespace common\model;

class PaymentDetailsMo {
	public $ccName;
	public $ccType;
	public $ccNumber;
	public $ccYear;
	public $ccMonth;
	public $ccCvv;
	public $paymentStatus;
	public $description;
	public function __construct() {
	}
}