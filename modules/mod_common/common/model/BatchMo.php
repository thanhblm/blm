<?php

namespace common\model;

use common\persistence\base\vo\BatchVo;

class BatchMo extends BatchVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["batch_group_name"] = "batchGroupName";
		$this->resultMap ["cr_name"] = "crName";
		$this->resultMap ["md_name"] = "mdName";
		$this->resultMap ["reports_range"] = "reportsRange";
	}
	public $batchGroupName;
	public $crName;
	public $mdName;
	public $reportsRange;
}