<?php

namespace core\database;

abstract class BaseVo {
	protected $resultMap;
	protected $columnMap;
	public $start_record;
	public $end_record;
	public $order_by;
	public function __construct() {
		$this->resultMap = array ();
		$this->columnMap = array ();
	}
	public final function getResultMap() {
		return $this->resultMap;
	}
	public final function getColumnMap() {
		return $this->columnMap;
	}
}