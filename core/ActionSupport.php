<?php

namespace core;

use core\utils\AppUtil;

class ActionSupport {
	private $fieldErrors = array ();
	private $actionErrors = array ();
	private $actionMessages = array ();
	private $redirectParams = array ();
	public function addRedirectParams($name, $value) {
		if (! AppUtil::isEmptyString ( $name )) {
			$this->redirectParams [$name] = $value;
		}
	}
	public function getRedirectParams() {
		return $this->redirectParams;
	}
	public function getFieldErrors() {
		return array_keys ( $this->fieldErrors );
	}
	public function getFieldErrorMessages() {
		return array_values ( $this->fieldErrors );
	}
	public function addFieldError($field, $errorMessage) {
		if (! AppUtil::isEmptyString ( $field ) && ! AppUtil::isEmptyString ( $errorMessage )) {
			$this->fieldErrors [$field] [] = $errorMessage;
		}
	}
	public function clearFieldErrors() {
		$this->fieldErrors = array ();
	}
	public function clearErrorField($field) {
		if (! AppUtil::isEmptyString ( $field )) {
			unset ( $this->fieldErrors [$field] );
		}
	}
	public function hasFieldErrors() {
		return count ( $this->fieldErrors ) > 0;
	}
	public function addActionError($message) {
		if (! AppUtil::isEmptyString ( $message )) {
			$this->actionErrors [] = $message;
		}
	}
	public function clearActionErrors() {
		$this->actionErrors = array ();
	}
	public function getActionErrors() {
		return $this->actionErrors;
	}
	public function hasActionErrors() {
		return count ( $this->actionErrors ) > 0;
	}
	public function addActionMessage($message) {
		if (! AppUtil::isEmptyString ( $message )) {
			$this->actionMessages [] = $message;
		}
	}
	public function clearActionMessages() {
		$this->actionMessages = array ();
	}
	public function getActionMessages() {
		return $this->actionMessages;
	}
	public function hasActionMessages() {
		return count ( $this->actionMessages ) > 0;
	}
	public function hasErrors() {
		return $this->hasFieldErrors () || $this->hasActionErrors ();
	}
	public function beforeExecute() {
		unset ( $_REQUEST [CTX] );
	}
	public function afterExecute() {
		// Set field, action error/message into the $_REQUEST to get from view.
		$_REQUEST [CTX] [ACTION_MESSAGES] = $this->actionMessages;
		$_REQUEST [CTX] [ACTION_ERRORS] = $this->actionErrors;
		$_REQUEST [CTX] [FIELD_ERRORS] = $this->fieldErrors;
		$_REQUEST [CTX] [REDIRECT_PARAMS] = $this->redirectParams;
	}
}