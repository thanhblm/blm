<?php

namespace common\filter\slide;

use common\persistence\base\vo\SlideVo;

class SlideFilter extends SlideVo {
	public $slideGroupName;
    public $slideGroupCode;
	public $crDateFrom;
	public $crDateTo;
	public $mdDateFrom;
	public $mdDateTo;
	public $crByName;
	public $mdByName;
	public $reportsRangeFrom;
	public $reportsRangeTo;
}
