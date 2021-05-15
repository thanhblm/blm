<?php

namespace common\vo\region\payment_method\bank_transfer;

use core\BaseArray;

class BankTransferSettingVo {
	public $status;
	public $pendingOrderStatus;
	public $infoTexts;
	public function __construct() {
		$this-> traceTexts = new BaseArray ( BankTransferLangTextVo::class );
	}
}