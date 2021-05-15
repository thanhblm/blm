<?php

namespace common\model;

use common\persistence\base\vo\SlideVo;

class SlideMo extends SlideVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["slide_group_name"] = "slideGroupName";
        $this->resultMap ["slide_group_code"] = "slideGroupCode";
		$this->resultMap ["cr_name"] = "crName";
		$this->resultMap ["md_name"] = "mdName";
		$this->resultMap ["reports_range"] = "reportsRange";
	}
	public $slideGroupName;
    public $slideGroupCode;
	public $crName;
	public $mdName;
	public $reportsRange;
}