<?php

namespace core\template\html\base;

class CommonElement extends HtmlElement {
	public function __construct($template = null, $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		parent::__construct ( $template, $id, $attributes );
	}
	protected final function getDefaultTemplate() {
		return null;
	}
}