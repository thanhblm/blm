<?php

namespace core\template\html\base;

class BaseForm extends HtmlElement {
	public $elements = array ();
	public $action = "";
	public $method = "post";
	public $enctype = "";
	public $ufid = "";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
		$this->ufid = uniqid();
	}
	public function addElement($element) {
		$this->elements [] = $element;
	}
	public function removeAllElement() {
		$this->$elements = array ();
	}
	protected final function getDefaultTemplate() {
		return "form";
	}
}