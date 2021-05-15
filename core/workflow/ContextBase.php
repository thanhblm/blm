<?php

namespace core\workflow;

class ContextBase {
	private $context = array ();
	public function __construct($context = null) {
		if (! isset ( $context ) || is_null($context)) {
			$this->context = array ();
		} else {
			$this->context = $context;
		}
	}
	public function get($key) {
		try {
			if (! isset ( $key )) {
				return null;
			}
			if (isset ( $this->context [$key] )) {
				$value = $this->context [$key];
			} else {
				$value = null;
			}
			return $value;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function set($key, $value) {
		try {
			if (! isset ( $key )) {
				return false;
			}
			$this->context [$key] = $value;
			return true;
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function __toString() {
	}
}