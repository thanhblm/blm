<?php
namespace common\template\extend;
use core\template\html\base\BaseTextArea;
class TextArea extends BaseTextArea {
	public $placeholder = "";
	public $class="";
	public $required = false;
	public $hasError = false;
	public $errorMessage = false;
	public $label = "";
	public $readonly = false;
	public function __construct($template = "textarea", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		parent::__construct ( $template, $id, $attributes );
	}
}