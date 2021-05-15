<?php

namespace common\template\extend;

use core\template\html\base\BaseButton;

class Button extends BaseButton {
	public $placeholder = "";
	public $class="";
	public $extraClass;
	public $icon = "";
	public function __construct($template = "button", $id = null, $attributes = null) {
		if (empty($template)){
			throw new \Exception("template required.");
		}
		parent::__construct ( $template, $id, $attributes );
	}
}