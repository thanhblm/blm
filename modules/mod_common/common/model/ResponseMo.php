<?php

namespace common\model;

use core\Lang;

class ResponseMo {
	public $status;
	public $msg;
	public $data;
	public $orderHistDetail;
	function __construct() {
		$this->status = null;
		$this->msg = Lang::get ( 'unhandled response.' );
		$this->data = null;
		$this->orderHistDetail = new OrderHistoryDetailMo ();
	}
}