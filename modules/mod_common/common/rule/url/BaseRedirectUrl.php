<?php

namespace common\rule\url;

use core\config\ApplicationConfig;
use core\utils\ActionUtil;
use core\utils\AppUtil;

abstract class BaseRedirectUrl {
	protected $uri;
	public function __construct($uri) {
		$this->uri = $uri;
	}
	public abstract function getUrl();
	protected function removeContext($uri) {
		$context = is_null ( ApplicationConfig::get ( 'web.context' ) ) ? "" : ApplicationConfig::get ( 'web.context' );
		// Check if the context is in url.
		if (! AppUtil::isEmptyString ( $context ) && 0 === strpos ( $uri, $context )) {
			// Remove context from url.
			$uri = substr ( $uri, strlen ( $context ), strlen ( $uri ) - strlen ( $context ) );
		}
		return $uri;
	}
	protected function getFullUri($uri) {
		if (false === strpos ( $uri, "http://", 0 ) && false === strpos ( $uri, "https://", 0 )) {
			$uri = substr ( $uri, 1 );
			return ActionUtil::getFullPathAlias ( $uri );
		}
		return $uri;
	}
	protected function getDefaultLangCode() {
		$langCode = ApplicationConfig::get ( "language.default.code" );
		$langCode = AppUtil::isEmptyString ( $langCode ) ? "en" : $langCode;
		return $langCode;
	}
}