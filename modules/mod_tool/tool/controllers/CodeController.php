<?php

namespace tool\controllers;

use core\Controller;
use core\tools\CodeGen;
use core\utils\AppUtil;

class CodeController extends Controller {
	public $dbName;
	public $tableName;
	public $destFolder;
	public $moduleName;
	public function generate() {
		// Only gen code when it's post.
		if ($_POST) {
			// Valid input.
			$this->validInput ();
			if ($this->hasFieldErrors ()) {
				return "success";
			}
			// Generate code.
			$moduleName = AppUtil::isEmptyString ( $this->moduleName ) ? "app" : $this->moduleName;
			$tableName = AppUtil::isEmptyString ( $this->tableName ) ? null : $this->tableName;
			$codeGen = new CodeGen ( $this->dbName, $moduleName, $tableName );
			$codeGen->destFolder = $this->destFolder;
			$codeGen->genAll ();
			// Add action message.
			$this->addActionMessage ( "Code was generated successfull." );
		}
		return "success";
	}
	private function validInput() {
		if (AppUtil::isEmptyString ( $this->dbName )) {
			$this->addFieldError ( "dbName", "The database name is required." );
		}
		if (AppUtil::isEmptyString ( $this->destFolder )) {
			$this->addFieldError ( "destFolder", "The destination folder is required." );
		}
	}
}