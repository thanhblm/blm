<?php

namespace common\rule\url;

use core\utils\AppUtil;

class UrlBuilder {
	private $protocol;
	private $host;
	private $context;
	private $langCode;
	private $path;
	private $queryString;
	public function protocol($protocol) {
		$this->protocol = $protocol;
		return $this;
	}
	public function host($host) {
		$this->host = $host;
		return $this;
	}
	public function context($context) {
		if (!AppUtil::isEmptyString($context)){
			$context = substr($context, 1);
		}
		$this->context = $context;
		return $this;
	}
	public function lang($lang) {
		$this->langCode = $lang;
		return $this;
	}
	public function path($path) {
		$this->path = $path;
		return $this;
	}
	public function query($query) {
		$this->queryString = $query;
		return $this;
	}
	public function getUrl() {
		$url = "#{PROTOCOL}://#{HOST}/#{CONTEXT}/#{LANG}/#{PATH}?#{QUERY_STRING}";
		// Replace at first.
		$replaceMap = array ();
		$replaceMap ["#{PROTOCOL}"] = AppUtil::isEmptyString ( $this->protocol ) ? "#{PROTOCOL}" : $this->protocol;
		$replaceMap ["#{HOST}"] = AppUtil::isEmptyString ( $this->host ) ? "#{HOST}" : $this->host;
		$replaceMap ["#{CONTEXT}"] = AppUtil::isEmptyString ( $this->context ) ? "#{CONTEXT}" : $this->context;
		$replaceMap ["#{LANG}"] = AppUtil::isEmptyString ( $this->langCode ) ? "#{LANG}" : $this->langCode;
		$replaceMap ["#{PATH}"] = AppUtil::isEmptyString ( $this->path ) ? "#{PATH}" : $this->path;
		$replaceMap ["#{QUERY_STRING}"] = AppUtil::isEmptyString ( $this->queryString ) ? "#{QUERY_STRING}" : $this->queryString;
		$url = AppUtil::replaceByMap ( $replaceMap, $url );
		// Replace at second.
		$replaceMap = array ();
		$replaceMap ["#{PROTOCOL}://"] = "";
		$replaceMap ["#{HOST}/"] = "";
		$replaceMap ["#{CONTEXT}/"] = "";
		$replaceMap ["#{LANG}/"] = "";
		$replaceMap ["#{PATH}"] = "";
		$replaceMap ["?#{QUERY_STRING}"] = "";
		$url = AppUtil::replaceByMap ( $replaceMap, $url );
		return $url;
	}
}