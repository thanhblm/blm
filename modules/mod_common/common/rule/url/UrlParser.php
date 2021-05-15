<?php

namespace common\rule\url;

use common\persistence\base\vo\LanguageVo;
use common\services\language\LanguageService;
use core\config\ApplicationConfig;
use core\utils\AppUtil;

class UrlParser {
	private $context;
	private $langCode;
	private $url;
	private $protocol;
	private $host;
	private $port;
	private $path;
	private $queryString;
	/**
	 *
	 * @param String $url
	 *        	Full path of Url
	 */
	public function __construct($url) {
		$this->url = $url;
		$urlParts = parse_url ( $url );
		$this->protocol = isset ( $urlParts ["scheme"] ) ? $urlParts ["scheme"] : "";
		$this->host = isset ( $urlParts ["host"] ) ? $urlParts ["host"] : "";
		$this->port = isset ( $urlParts ["port"] ) ? $urlParts ["port"] : "";
		$this->path = isset ( $urlParts ["path"] ) ? $urlParts ["path"] : "";
		$this->queryString = isset ( $urlParts ["query"] ) ? $urlParts ["query"] : "";
		$context = ApplicationConfig::get ( 'web.context' );
// 		if (! AppUtil::isEmptyString ( $context )) {
// 			$context = substr ( $context, 1, strlen ( $context ) - 1 );
// 		}
		$this->context = $context;
		// Remove context from path.
		$this->removeContextFromPath ();
		// Get language code and path.
		// Get default language code.
		$defaultLangCode = $this->getDefaultLangCode ();
		$parts = explode ( "/", $this->path );
		$this->langCode = $parts [0];
		// Check language code from the database.
		if (is_null ( $this->getLanguageByCode () )) {
			$this->langCode = $defaultLangCode;
		}
		// Remove lang code from path.
		$this->removeLangCodeFromPath ();
	}
	public function getProtocol() {
		return $this->protocol;
	}
	public function getHost() {
		return $this->host;
	}
	public function getPort() {
		return $this->port;
	}
	public function getPath() {
		return $this->path;
	}
	public function getQueryString() {
		return $this->queryString;
	}
	public function getFragment() {
		return $this->fragment;
	}
	public function getLangCode() {
		return $this->langCode;
	}
	public function getContext() {
		return $this->context;
	}
	private function removeContextFromPath() {
		$this->path = substr($this->path, strlen( $this->context)+1);
		
		/*
		if (AppUtil::isEmptyString ( $context)) {
			
			return;
		}
		
		$removeContext = "/" . $this->context . "/";
		if ($this->path === $removeContext) {
			$this->path = "";
			return;
		} else if (strlen ( $this->path ) < strlen ( $removeContext )) {
			return;
		}
		// Check if the context is in path.
		if (0 === strpos ( $this->path, $removeContext )) {
			// Remove context from url.
			$this->path = substr ( $this->path, strlen ( $removeContext ), strlen ( $this->path ) - strlen ( $removeContext ) );
		}
		*/
		
	}
	private function removeLangCodeFromPath() {
		$removeLang = $this->langCode;
		if ($this->path === $removeLang) {
			$this->path = "";
			return;
		} else if (strlen ( $this->path ) < strlen ( $removeLang )) {
			return;
		}
		$removeLang = $removeLang . "/";
		// Check if the lang code is in path.
		if (0 === strpos ( $this->path, $removeLang )) {
			// Remove lang code from url.
			$this->path = substr ( $this->path, strlen ( $removeLang ), strlen ( $this->path ) - strlen ( $removeLang ) );
			return;
		}
		if ("/" === $this->path) {
			$this->path = "";
		}
	}
	private function getDefaultLangCode() {
		$langCode = ApplicationConfig::get ( "language.default.code" );
		$langCode = AppUtil::isEmptyString ( $langCode ) ? "en" : $langCode;
		return $langCode;
	}
	private function getLanguageByCode() {
		$filter = new LanguageVo ();
		$filter->code = $this->langCode;
		$languageService = new LanguageService ();
		$languageVo = $languageService->getLanguageByCode ( $filter );
		return $languageVo;
	}
}