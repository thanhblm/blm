<?php

namespace __MODULE_NAME__\persistence\base\vo;

use core\database\BaseVo;

class __CLASS_NAME__Vo extends BaseVo {
	//__FIELD_DECLARATION__
	
	public function __construct() {
		parent::__construct ();
		$this->resultMap = array (
			__RESULT_MAPPING__ 
		);
		$this->columnMap = __COLUMN_MAPPING__;
	}
}