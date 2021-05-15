<?php

namespace core;

use core\config\ApplicationConfig;
use core\utils\AppUtil;
use core\utils\SessionUtil;
use core\config\FConstants;

class Controller extends ActionSupport {
	public $extra;
	public $pageTitle;
	public function __construct() {
		$this->pageTitle = ApplicationConfig::get ( "site.name" );
		$this->extra = array ();
	}
	protected function setAttribute($attrName, $attrValue) {
		$_REQUEST [$attrName] = $attrValue;
	}
	protected function setAttributes($arrAttributes) {
		if (isset ( $arrAttributes )) {
			foreach ( $arrAttributes as $key => $value ) {
				$_REQUEST [$key] = $value;
			}
		}
	}
	public function execute($method) {
		$this->beforeExecute ();
		$reflectionMethod = new \ReflectionMethod ( $this, $method );
		$result = $reflectionMethod->invoke ( $this );
		$this->afterExecute ();
		return $result;
	}
	public function beforeExecute() {
		parent::beforeExecute ();
	}
	public function afterExecute() {
		parent::afterExecute ();
	}
	function __destruct() {
	}
	public function __set($property, $value) {
		$method = "set{$property}";
		if (method_exists ( $this, $method )) {
			return $this->$method ( $value );
		}
	}
	public function __get($property) {
		$method = "get{$property}";
		if (method_exists ( $this, $method )) {
			return $this->$method ();
		}
	}
	public function handleError(\Exception $e) {
		\DatoLogUtil::error ( $e->getMessage () );
		$this->addActionError ( $e->getMessage () );
	}
	public function getUserInfo() {
		return SessionUtil::get ( ApplicationConfig::get("session.user.login.name")  );
	}
	public function addExtraData($field, $value) {
		if (! AppUtil::isEmptyString ( $field )) {
			$this->extra [$field] = $value;
		}
	}
	
	public function disableLayout() {
		$_REQUEST [CTX] [LAYOUT_OPTION] = FConstants::NO_FLAG;
	}
	
	public function enableLayout() {
		$_REQUEST [CTX] [LAYOUT_OPTION] = FConstants::YES_FLAG;
	}
}