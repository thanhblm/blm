<?php

namespace common\model;

use common\persistence\base\vo\UserVo;

class UserMo extends UserVo {
	public function __construct() {
		parent::__construct ();
		$this->resultMap ["ug_name"] = "ugName";
	}
	public $ugName;
}