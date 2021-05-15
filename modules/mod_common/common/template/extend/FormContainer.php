<?php

namespace common\template\extend;

use core\Lang;
use core\template\html\base\BaseForm;

class FormContainer extends BaseForm {
	public $beginTemplate;
	public $endTemplate;
	public function __construct($beginTemplate = "form_container_start", $endTemplate = "form_container_end",  $id = null, $attributes = null) {
		if (empty($beginTemplate)){
			throw new \Exception("Begin template required.");
		}
		if (empty($endTemplate)){
			throw new \Exception("End template required.");
		}
		$this->beginTemplate = $beginTemplate;
		$this->endTemplate = $endTemplate;
		$template = "";
		parent::__construct ( $template, $id, $attributes );
	}
	
	public function renderStart(){
		$this->template = $this->beginTemplate;
		$this->render();
		
	}
	public function renderEnd(){
		$this->template = $this->endTemplate;
		$this->render();
	}
}