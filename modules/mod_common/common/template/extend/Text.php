<?php

namespace common\template\extend;

use core\template\html\base\BaseText;

class Text extends BaseText {
	public $placeholder = "";
	public $class="";
	public function __construct($template = "text", $id = null, $attributes = null) {
		if (empty($template)){
			throw new \Exception("template required.");
		}
		parent::__construct ( $template, $id, $attributes );
	}
}