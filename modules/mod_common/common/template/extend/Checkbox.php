<?php

namespace common\template\extend;

use core\template\html\base\BaseCheckBox;

class Checkbox extends BaseCheckBox {
	public $required = false;
	public $hasError = false;
	public $errorMessage = false;
	public $label = "";
	public $readonly = false;
	public $prepend = '';
	public $append = '';
	public function __construct($template = "checkbox", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		parent::__construct ( $template, $id, $attributes );
	}
}