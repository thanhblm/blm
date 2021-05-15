<?php

namespace common\template\extend;

use core\template\html\base\BaseButton;
use Box\Spout\Writer\Style\Color;

class ButtonAction extends BaseButton {
	const COLOR_RED = "red";
	const COLOR_BLUE = "blue";
	const COLOR_GREEN = "green";
	const COLOR_YELLOW = "yellow ";
	const COLOR_PURPLE = "purple";
	const COLOR_DARK = "dark";
	const COLOR_DEFAULT = "default";
	public $iconClass;
	public $js;
	public $url;
	public $color = self::COLOR_DEFAULT;
	public function __construct($template = "button_action", $id = null, $attributes = null) {
		if (empty ( $template )) {
			throw new \Exception ( "template required." );
		}
		parent::__construct ( $template, $id, $attributes );
	}
}