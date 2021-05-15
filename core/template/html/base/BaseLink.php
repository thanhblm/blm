<?php

namespace core\template\html\base;

class BaseLink extends HtmlElement {
	public $title = "";
	public $link = "#";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
	protected final function getDefaultTemplate() {
		return "link";
	}
}