<?php

namespace common\template\extend;
use core\template\html\base\HtmlElement;

/**
 * render image (img tag)
 * show small (or large) image and popup image orgial
 * if image not exist return no-image.png
 * 
 * @param $size string (small*, large, '')
 * 	value = upload/images/vdato.jpg
 * 	$size = 'small'
 * 		-> output: 	upload/images/small/vdato.jpg
 * 	$size = 'large'
 * 		-> output: 	upload/images/large/vdato.jpg
 * 	$size = ''
 * 		-> output: 	upload/images/vdato.jpg
 */
class Image extends HtmlElement {
	public $required = false;
	public $hasError = false;
	public $errorMessage = false;
	public $label = "";
	public $readonly = false;
	
	public $value = '';
	public $class = '';
	public $id = '';
	public $name = '';
	public $size = 'small';
	
	public function __construct($template = "image", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		
		parent::__construct ( $template, $id, $attributes );
	}
	
	protected final function getDefaultTemplate() {
		return "image";
	}
}