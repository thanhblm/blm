<?php

use common\rule\url\friendly\AliasUrlFriendly;
use core\App;
use core\config\ActionConfig;
use core\config\ApplicationConfig;
use core\utils\ActionUtil;
use core\utils\AppUtil;

date_default_timezone_set('UTC');
function exceptionHandler($exception){
	$errorMessageId = uniqid();
	$errorMessage = "";
	DatoLogUtil::error("Error Message Id: " . $errorMessageId);
	DatoLogUtil::error($exception->getMessage() . " Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine());
	DatoLogUtil::error($exception);
	$errorMessage .= "<h1>Error:" . $exception->getCode() . "</h1>";
	$errorMessage .= "<p>Error Message Id: " . $errorMessageId . "</p>";
	$errorMessage .= "<p>Uncaught exception: '" . get_class($exception) . "'</p>";
	$errorMessage .= "<p>Message: '" . $exception->getMessage() . "'</p>";
	$errorMessage .= "<p>Thrown in '" . $exception->getFile() . "' on line " . $exception->getLine() . "</p>";
	$errorMessage .= "<p>Stack trace:<pre>" . $exception->getTraceAsString() . "</pre></p>";
	DatoLogUtil::error($errorMessage);
	errorHandler($errorMessage, $errorMessageId, $exception->getCode());
}

function fatalErrorShutdownHandler(){
	$last_error = error_get_last();
	if (isset ($last_error) && ($last_error ['type'] & (E_ERROR | E_USER_ERROR | E_CORE_ERROR | E_COMPILE_ERROR | E_RECOVERABLE_ERROR | E_PARSE))) {
		$errorMessage = "";
		$errorMessageId = uniqid();
		$errorMessage = "Error Message Id: " . $errorMessageId . " " . $last_error ['type'] . " - " . $last_error ['message'] . " in " . $last_error ['file'] . " at line " . $last_error ['line'];
		DatoLogUtil::error("Error Message Id: " . $errorMessageId);
		DatoLogUtil::error($errorMessage);
		DatoLogUtil::error($last_error);
		errorHandler($errorMessage, $errorMessageId);
	}
}

function errorHandler($errorMessage, $errorMessageId = null, $errorCode = null){
	$customMessage = $errorMessage;
	if (ApplicationConfig::get('production.mode') !== 'dev') {
		$customMessage = AppUtil::defaultIfEmpty(ApplicationConfig::get("system.error.message"), "Server internal error, please contact the administrator.");
		$customMessage = "Error Message Id: " . $errorMessageId . " " . $customMessage;
	}
	$isJsonRequest = isset ($_REQUEST ["rtype"]) && "json" === $_REQUEST ["rtype"];

	if ($isJsonRequest) {
		header("Content-Type: application/json");
		echo json_encode(array(
			'errorCode' => 'ACTION_ERROR',
			'errorMessage' => $customMessage,
			'content' => ""
		));
	} else {
		switch ($errorCode) {
			case 404:
				$errorPath = "err/404";
// 				if ($errorPath === RouteUtil::getRoute()->getPath()){
// 					header ( 'location:' . ActionUtil::getFullPathAlias(""));
// 					return;
// 				}
				if (is_null(ActionConfig::getActionMap($errorPath))) {
					echo $customMessage;
				} else {
					$friendlyName = null;
					if (!is_null(ApplicationConfig::get("action.alias.list"))) {
						foreach (ApplicationConfig::get("action.alias.list") as $key => $value) {
							if ($value === $errorPath) {
								$friendlyName = $key;
								break;
							}
						}
					}
					if (!is_null($friendlyName)) {
						header('location:' . ActionUtil::getFullPathAlias($errorPath, new AliasUrlFriendly($friendlyName)));
					} else {
						header('location:' . ActionUtil::getFullPathAlias($errorPath));
					}
					return;
				}
				break;
			default:
				echo $customMessage;
				break;
		}
	}
}

// Turn off error reporting.
error_reporting(0);
set_exception_handler("exceptionHandler");
register_shutdown_function('fatalErrorShutdownHandler');
require_once(ROOT . DS . 'core' . DS . 'App.php');
$cfgs = array(
	"APP_SETTINGS" => ROOT . DS . 'app' . DS . 'config' . DS . 'app_config.php',
	// "ACTION_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'action_config.php',
	"FILTER_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'filter_config.php',
	// "LAYOUT_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'layout_config.php',
	"REDIRECT_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'redirect_config.php',
	"FRIENDLY_URL_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'friendly_url_config.php',
	"MODULE_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'module_config.php'
);
// "WORKFLOW_CONFIG" => ROOT . DS . 'app' . DS . 'config' . DS . 'workflow_config.php'

$app = new App ();
if (php_sapi_name() === 'cli') {
	$app->runCli($cfgs, $argv);
} else {
	$app->run($cfgs);
}