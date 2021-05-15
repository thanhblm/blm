<?php

namespace common\template\extend;
use core\template\html\base\BaseLink;

class Link extends BaseLink {
	public $class="";
	public function __construct($template = "link", $id = null, $attributes = null) {
		if (empty($template)){
			throw new \Exception("template required.");
		}
		parent::__construct ( $template, $id, $attributes );
	}
}