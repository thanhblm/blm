<?php

namespace common\filter\manufacture;

use common\persistence\base\vo\ManufactureVo;

class ManufactureFilter extends ManufactureVo {
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $crByName;
	public $mdByName;
}
