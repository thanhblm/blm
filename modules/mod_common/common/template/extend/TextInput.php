<?php

namespace common\template\extend;

class TextInput extends Text {
	public $required = false;
	public $hasError = false;
	public $errorMessage = false;
	public $label = "";
	public $readonly = false;
    public $prepend = '';
    public $append = '';
    public $helperText = '';
	public function __construct($template = "text_input", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		
		parent::__construct ( $template, $id, $attributes );
	}
}