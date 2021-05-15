<?php

namespace common\template\extend;


use core\template\html\base\CommonElement;
class PagingTemplate extends CommonElement {
	public $paging = "";
	public $changePageJs = "";
	public function __construct($template = "paging", $id = null, $attributes = null) {
		if (empty($template)){
			throw new \Exception("template required.");
		}
		parent::__construct ( $template, $id, $attributes );
	}
}