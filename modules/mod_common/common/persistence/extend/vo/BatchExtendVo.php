<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\BatchVo;

class BatchExtendVo extends BatchVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["cr_by_name"] = "crByName";
		$this->resultMap ["md_by_name"] = "mdByName";
		$this->resultMap ["batch_group_name"] = "batchGroupName";
		$this->resultMap ["batch_id"] = "batchId";
		
	}
	public $crByName;
	public $mdByName;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $batchGroupName;
	public $batchId;
}