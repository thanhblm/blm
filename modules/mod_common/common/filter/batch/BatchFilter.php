<?php

namespace common\filter\batch;

use common\persistence\base\vo\BatchVo;

class BatchFilter extends BatchVo {
	public $batchGroupName;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $crByName;
	public $mdByName;
	public $reportsRangeFrom;
	public $reportsRangeTo;
}
