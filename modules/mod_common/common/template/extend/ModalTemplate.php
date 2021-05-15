<?php

namespace common\template\extend;


use core\template\html\base\CommonElement;
class ModalTemplate extends CommonElement {
	public $isStatic = true;
	public $size;
	public $extraClass;
	public function __construct($template = "modal", $id = null, $attributes = null) {
		if (empty($template)){
			throw new \Exception("template required.");
		}
		parent::__construct ( $template, $id, $attributes );
	}
}