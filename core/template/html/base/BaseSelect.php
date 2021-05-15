<?php

namespace core\template\html\base;



class BaseSelect extends HtmlElement {
	const CT_SINGLE_ARRAY_VALUE = 0;
	const CT_MULTI_ARRAY_VALUE = 1;
	const CT_SINGLE_ARRAY_OBJECT = 2;
	public $value = "";
	public $collectionType = 2;
	public $collections = array ();
	public $propertyName = "";
	public $propertyValue = "";
	public $headerKey = null;
	public $headerValue = null;
	public $i18n = false;
	
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
	protected final function getDefaultTemplate() {
		return "select";
	}
}