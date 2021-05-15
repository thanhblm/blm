<?php

namespace tool\controllers;

use core\Controller;
use core\utils\AppUtil;
use core\utils\PhpFileUtil;
use core\utils\TextFileUtil;

class InterfaceController extends Controller {
	public $srcFolder;
	public $destFolder;
	public function generate() {
		// Only gen code when it's post.
		if ($_POST) {
			// Valid input.
			$this->validInput ();
			if ($this->hasErrors ()) {
				return "success";
			}
			$this->generateInterfaces ();
			// Add action message.
			$this->addActionMessage ( "Code was generated successfull." );
		}
		return "success";
	}
	private function validInput() {
		if (AppUtil::isEmptyString ( $this->srcFolder )) {
			$this->addFieldError ( "srcFolder", "Source folder is required." );
		} else {
			if (! file_exists ( $this->srcFolder )) {
				$this->addFieldError ( "srcFolder", "The source folder doesn't exist." );
			}
		}
		if (AppUtil::isEmptyString ( $this->destFolder )) {
			$this->addFieldError ( "destFolder", "The destination folder is required." );
		} else {
			if (! file_exists ( $this->destFolder )) {
				$this->addFieldError ( "destFolder", "The destination folder doesn't exist." );
			}
		}
	}
	private function generateInterfaces() {
		set_time_limit(0);
		$this->createInterfaceFile ( $this->srcFolder, $this->destFolder );
	}
	private function createInterfaceFile($srcFolder, $destFolder) {
		// Check existence of the dest folder.
		if (! file_exists ( $destFolder )) {
			mkdir ( $destFolder );
		}
		foreach ( scandir ( $srcFolder ) as $file ) {
			// Directory.
			if (is_dir ( $srcFolder . DS . $file ) && substr ( $file, 0, 1 ) !== '.') {
				$newSrcFolder = $srcFolder . DS . $file;
				$newDestFolder = $destFolder . DS . $file;
				$this->createInterfaceFile ( $newSrcFolder, $newDestFolder );
			}
			// PHP File.
			if (substr ( $file, 0, 2 ) !== '._' && preg_match ( "/.php$/i", $file )) {
				// Create file.
				$oldFilePathName = $srcFolder . DS . $file;
				$newFilePathName = $destFolder . DS . $file;
				$fileContent = PhpFileUtil::getInterfaceFileContext2( $oldFilePathName );
				if (! AppUtil::isEmptyString ( $fileContent )) {
					TextFileUtil::writeFile ( $newFilePathName, $fileContent );
				}
			}
		}
	}
}