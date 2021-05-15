<?php

namespace common\filter\payment;

use core\database\BaseVo;

class PaymentFilter extends BaseVo {
	public $id;
	public $name;
	public $description;
	public $status;
}
