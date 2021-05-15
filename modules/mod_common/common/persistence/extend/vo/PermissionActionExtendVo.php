<?php

namespace common\persistence\extend\vo;

use common\persistence\base\vo\PermissionActionVo;

class PermissionActionExtendVo extends PermissionActionVo {
	public $id;
	public function __construct() {
		parent::__construct ();
	}
}