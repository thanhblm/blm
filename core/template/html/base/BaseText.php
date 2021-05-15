<?php

namespace core\template\html\base;

class BaseText extends HtmlElement {
	public $type = "text";
	public $value = "";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
	protected final function getDefaultTemplate() {
		return "text";
	}
}