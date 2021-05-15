<?php

namespace core\template\html\base;

class Container extends CommonElement {
	public $elements = array ();
	public $beginTemplate = "";
	public $endTemplate = "";
	public function __construct($template = null, $id = null, $attributes = null) {
		parent::__construct ( $template, $id, $attributes );
	}
	public function addElement($element) {
		$this->elements [] = $element;
	}
	public function removeAllElement() {
		$this->$elements = array ();
	}
	public function renderStart() {
		$old = $this->template;
		$this->template = $this->beginTemplate;
		if (! empty ( $this->template )) {
			$this->render ();
		}
		$this->template = $old;
	}
	public function renderEnd() {
		$old = $this->template;
		$this->template = $this->endTemplate;
		if (! empty ( $this->template )) {
			$this->render ();
		}
		$this->template = $old;
	}
}