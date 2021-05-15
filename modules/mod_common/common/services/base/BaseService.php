<?php

namespace common\services\base;

class BaseService {
	protected $context;
	public function __construct($context = array()) {
		$this->context = $context;
	}
}