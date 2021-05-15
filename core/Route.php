<?php

namespace core;

use core\utils\AppUtil;
use core\config\ApplicationConfig;
use core\config\ActionConfig;

class Route {
	private $webRoot;
	private $uri;
	private $lang;
	private $path;
	private $queryString;
	private $module;
	public function __construct($uri) {
		$this->uri = urldecode ( trim ( $uri, '/' ) );
		$this->parseUri ();
	}
	private function parseUri() {
		// Split uri by ? to get path and query string.
		$urlParts = explode ( "?", $this->uri );
		// Get query string.
		if (isset ( $urlParts [1] )) {
			$this->queryString = $urlParts [1];
		}
		// Get web root.
		$webRoot='http'.(empty($_SERVER['HTTPS'])?'':'s').'://'.$_SERVER['HTTP_HOST']. ApplicationConfig::get ( 'web.context' );

		$this->webRoot = $webRoot;
		// Get actionPath
		$pathParts = explode ( "/", $urlParts [0] );
		if (!AppUtil::isEmptyString(ApplicationConfig::get ( 'web.context' ))){
			array_shift ( $pathParts );
		}
		$path = implode ( "/", $pathParts );
		
		if (AppUtil::isEmptyString ( $path )) {
			$this->path = "";
		} else {
			$this->path = $path;
		}
		$this->module = is_null ( ActionConfig::getModule ( $this->path ) ) ? "" : ActionConfig::getModule ( $this->path );
	}
	public function getUri() {
		return $this->uri;
	}
	public function getLang() {
		return $this->lang;
	}
	public function getQueryString() {
		return $this->queryString;
	}
	public function getWebRoot() {
		return $this->webRoot;
	}
	public function getPath() {
		return $this->path;
	}
	public function getModule() {
		return $this->module;
	}
}