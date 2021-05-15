<?php

namespace core\template\html\base;

class BaseButton extends HtmlElement {
	public $title = "";
	public $type = "";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template);
	}
	protected final function getDefaultTemplate() {
		return "button";
	}
}