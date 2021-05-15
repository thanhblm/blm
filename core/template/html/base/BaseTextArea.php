<?php

namespace core\template\html\base;

class BaseTextArea extends HtmlElement {
	public $title = "";
	public $value = "";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
	protected final function getDefaultTemplate() {
		return "textarea";
	}
}