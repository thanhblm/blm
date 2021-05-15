<?php 
// no define function or class here, only perform script to call function or class from other PHP file
DatoLogUtil::devInfo($spl_param_class_name);
// $className= $spl_param_class_name;
// if (! $found) {
// 	$searchFileName = trim ( $className ) . ".php";
// 	$corePath = ROOT . DS . 'core';
// 	$appPath = ROOT . DS . 'app';
// 	$modulePath = ROOT . DS . 'modules';
// 	// Auto search and load.
// 	$found = $this->searchClassFile ( $searchFileName, $corePath );
// 	if (! $found) {
// 		$found = $this->searchClassFile ( $searchFileName, $appPath );
// 	}
// 	if (! $found) {
// 		$found = $this->searchModuleClassFile ( $searchFileName, $modulePath );
// 	}
// 	if (! $found) {
// 		throw new \Exception ( "The class [$className] doesn't exist" );
// 	} else {
// 		require_once $found;
// 	}
// }
?>