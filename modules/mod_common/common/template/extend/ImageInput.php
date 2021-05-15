<?php

namespace common\template\extend;
use core\template\html\base\HtmlElement;

/**
 * render image input
 * 
 * @param $action boolean default is false (show select and delete button)
 * @param $id string required and unique
 */
class ImageInput extends HtmlElement {
	public $required = false;
	public $hasError = false;
	public $errorMessage = false;
	public $label = "";
	public $readonly = false;
	public $profileId = "";
	public $hasImgAction = false;
	public $value = '';
	public $class = '';
	public $id = '';
	public $name = '';
	public $row = 1;	//show number row (value 1 or 2)
	
	public function __construct($template = "image_input", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		
		parent::__construct ( $template, $id, $attributes );
	}
	
	protected final function getDefaultTemplate() {
		return "image_input";
	}
}