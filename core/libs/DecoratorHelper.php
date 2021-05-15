<?php

namespace core\libs;

class DecoratorHelper {
	private $pattern;
	public function __construct($pattern) {
		$this->pattern = trim ( $pattern );
	}
	public function getExp() {
		$regExp = $this->pattern;
		// If the first character of pattern is *
		// then replace it by special regular expression.
		if (substr ( $regExp, 0, 1 ) == "*") {
			$regExp = "#@@#" . substr ( $regExp, 1 );
		}
		$regExp = str_ireplace ( "\\", "\\/", $regExp );
		$regExp = str_ireplace ( "/", "\\/", $regExp );
		$regExp = str_ireplace ( ".", "\\.", $regExp );
		$regExp = str_ireplace ( "*", "([a-zA-Z_])(\w*)", $regExp );
		$regExp = str_ireplace ( "#@@#", "([a-zA-Z_\/\\\\])([\w\\\\\.\/]*)", $regExp );
		return "/^" . $regExp . "$/";
	}
	public function isValid() {
		$regExp = "/^([a-zA-Z_\\\\*\/])([\w\\\\.\*\/]*)([a-zA-Z_\*]+)$/";
		return preg_match ( $regExp, $this->pattern );
	}
	public function getPattern() {
		return $this->pattern;
	}
}