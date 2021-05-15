<?php

namespace common\template\extend;

use core\template\html\base\Container;

class LabelContainer extends Container {
	public $textBefore = "";
	public $textAfter = "";
	public function __construct($template = "label_container", $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
}