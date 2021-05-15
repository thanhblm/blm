<?php

namespace core\filters;

use core\config\ActionConfig;
use core\config\FConstants;
use core\config\ModuleConfig;
use core\Controller;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\LayoutUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\View;

class MvcFilter implements Filter {
	public function init($filterConfig) {
	}
	public function doFilter($filterChain) {
		$this->dispatch ();
		$filterChain->doFilter ();
	}
	private function dispatch() {
		\DatoLogUtil::info ( " ======================= Begin controller execute " . RouteUtil::getRoute ()->getPath () . " ======================= " );
		// Get action map info.
		$actionInfo = ActionConfig::getActionMap ( RouteUtil::getRoute ()->getPath () );
		if (is_null ( $actionInfo )) {
			throw new \Exception ( "Not found configuration for the action [" . RouteUtil::getRoute ()->getPath () . "].", 404 );
		}
		// Check controller and method config.
		if (! isset ( $actionInfo ['controller'] ) || ! isset ( $actionInfo ['method'] )) {
			throw new \Exception ( "Not found configuration for the action [" . RouteUtil::getRoute ()->getPath () . "]." );
		}
		\DatoLogUtil::info ( $actionInfo );
		\DatoLogUtil::trace ( " ======================= Request before process " . RouteUtil::getRoute ()->getPath () . " ======================= " );
		\DatoLogUtil::trace ( $_REQUEST );
		// Get full controller name and method.
		$controllerClass = $actionInfo ['controller'];
		$controllerMethod = $actionInfo ['method'];
		// $controllerObject = new $controllerClass ();
		$reflectClass = new \ReflectionClass ( $controllerClass );
		$controllerObject = $reflectClass->newInstanceArgs ();
		// Calling controller's method.
		if (method_exists ( $controllerObject, $controllerMethod )) {
			// Prepare object properties.
			$arrayObjects = $_REQUEST;
			$props = $reflectClass->getProperties ( \ReflectionProperty::IS_PUBLIC );
			foreach ( $props as $prop ) {
				$value = $prop->getValue ( $controllerObject );
				// Not set value for controller if there isn't value get from the request.
				if (isset ( $arrayObjects [$prop->getName ()] )) {
					if (is_object ( $value )) {
						$prop->setValue ( $controllerObject, AppUtil::array2Object ( $arrayObjects [$prop->getName ()], get_class ( $value ), $value ) );
					} else {
						$prop->setValue ( $controllerObject, $arrayObjects [$prop->getName ()] );
					}
				}
			}
			\DatoLogUtil::trace ( " ======================= Begin controller execute " . RouteUtil::getRoute ()->getPath () . " ======================= " );
			\DatoLogUtil::trace ( $controllerObject );
			// Controller's action may return a view name.
			if ($controllerObject instanceof Controller) {
				$reflectionMethod = new \ReflectionMethod ( $controllerClass, 'execute' );
				$viewName = $reflectionMethod->invoke ( $controllerObject, $controllerMethod );
			} else {
				$viewName = $controllerObject->$controllerMethod ();
			}
			// Post data from controller to request.
			foreach ( $props as $prop ) {
				$value = $prop->getValue ( $controllerObject );
				$_REQUEST [$prop->getName ()] = $value;
			}
// 			\DatoLogUtil::trace ( " ======================= After controller execute " . RouteUtil::getRoute ()->getPath () . " ======================= " );
// 			\DatoLogUtil::trace ( $controllerObject );
// 			\DatoLogUtil::trace ( " ======================= Request after process  " . RouteUtil::getRoute ()->getPath () . " ======================= " );
// 			\DatoLogUtil::trace ( $_REQUEST );
			// Detect view.
			if (! AppUtil::isEmptyString ( $viewName )) {
				// Get view info.
				$viewInfo = LayoutUtil::getViewInfo ( $actionInfo, $viewName );
				if (is_null ( $viewInfo )) {
					throw new \Exception ( "No view config for the action [" . RouteUtil::getRoute ()->getPath () . "]." );
				}
				// Process view.
				if (isset ( $viewInfo ['type'] )) {
					switch ($viewInfo ['type']) {
						case "include" :
							if (! isset ( $viewInfo ['path'] )) {
								throw new \Exception ( "No view path config for the action [" . RouteUtil::getRoute ()->getPath () . "]." );
							}
							// Check view file exist?
							if (! file_exists ( ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::VIEW_PATH] . DS . $viewInfo ['path'] )) {
								throw new \Exception ( "The view [" . $viewInfo ['path'] . "] is not found." );
							}
							// Get layout.
							if  (isset($_REQUEST[CTX][LAYOUT_OPTION]) && $_REQUEST[CTX][LAYOUT_OPTION]== FConstants::NO_FLAG){
								$layoutPath= null;
							}else{
								$layout = LayoutUtil::getLayout ( RouteUtil::getRoute ()->getModule (), $viewInfo ['path'] );
								if (! is_null ( $layout )) {
									$layoutPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::LAYOUT_PATH] . DS . $layout;
									// Check layout file exist?
									if (! file_exists ( $layoutPath )) {
										throw new \Exception ( "The layout [" . $layout . "] is not found." );
									}
								} else {
									$layoutPath = null;
								}
							}
							// Render view.
							$viewObject = new View ( ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::VIEW_PATH] . DS . $viewInfo ['path'], $layoutPath );
							// Is JSON view?
							if (isset ( $_REQUEST ["rtype"] ) && "json" === $_REQUEST ["rtype"]) {
								// Render view.
								ob_start ();
								$viewObject->render ();
								$viewContent = ob_get_contents();
								ob_end_clean ();
								// Get info from called controller.
								if ($controllerObject->hasActionErrors ()) {
									$errorCode = "ACTION_ERROR";
									$errorMessage = RequestUtil::getErrorMessage ();
									\DatoLogUtil::error ( $errorMessage . " : " . substr($viewContent, 0, 250) );
								} else if ($controllerObject->hasFieldErrors ()) {
									$errorMessage = RequestUtil::getFieldErrors ();
									$errorCode = "FIELD_ERROR";
								} else {
									$errorMessage = RequestUtil::getActionMessage ();
									$errorCode = "SUCCESS";
								}
								// Return JSON object include view content.
								header ( "Content-Type: application/json" );
								echo json_encode ( array (
										'errorCode' => $errorCode,
										'errorMessage' => $errorMessage,
										'content' => $viewContent,
										'extra' => $controllerObject->extra 
								) );
							} else {
								$viewObject->render ();
							}
							break;
						case "redirect" :
							if (! isset ( $viewInfo ['path'] )) {
								throw new \Exception ( "No view path config for the action [" . RouteUtil::getRoute ()->getPath () . "]." );
							}
							$redirectUrl = $viewInfo ['path'];
							// Ignore the obsolute url.
							// Get full url if it's action path.
							if (false === strpos ( $redirectUrl, "http://", 0 ) && false === strpos ( $redirectUrl, "https://", 0 )) {
								$redirectUrl = ActionUtil::getFullPathAlias ( $redirectUrl );
							}
							// Get redirect params.
							$redirectParams = $controllerObject->getRedirectParams ();
							$queryString = "";
							foreach ( $redirectParams as $paramName => $paramValue ) {
								$queryString .= "&" . $paramName . "=" . urlencode ( $paramValue );
							}
							$queryString = substr ( $queryString, 1, strlen ( $queryString ) - 1 );
							// Check if the current request has query string?
							if (! AppUtil::isEmptyString ( $queryString )) {
								if (strpos ( $redirectUrl, '?' ) !== false) {
									$redirectUrl .= "&" . $queryString;
								} else {
									$redirectUrl .= "?" . $queryString;
								}
							}
							// Redirect.
							header ( 'location:' . $redirectUrl );
							break;
						case "json" :
							header ( "Content-Type: application/json" );
							if (! isset ( $viewInfo ['path'] )) {
								throw new \Exception ( "No view path config for the action [" . RouteUtil::getRoute ()->getPath () . "]." );
							}
							// Check view file exist?
							if (! file_exists ( ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::VIEW_PATH] . DS . $viewInfo ['path'] )) {
								throw new \Exception ( "The view [" . $viewInfo ['path'] . "] is not found." );
							}
							// Get layout.
							if  (isset($_REQUEST[CTX][LAYOUT_OPTION]) && $_REQUEST[CTX][LAYOUT_OPTION]== FConstants::NO_FLAG){
								$layoutPath= null;
							}else{
								$layout = LayoutUtil::getLayout ( RouteUtil::getRoute ()->getModule (), $viewInfo ['path'] );
								if (! is_null ( $layout )) {
									$layoutPath = ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::LAYOUT_PATH] . DS . $layout;
									// Check layout file exist?
									if (! file_exists ( $layoutPath )) {
										throw new \Exception ( "The layout [" . $layout . "] is not found." );
									}
								} else {
									$layoutPath = null;
								}
							}							
							// Get view.
							$viewObject = new View ( ModuleConfig::getModuleConfig ( RouteUtil::getRoute ()->getModule () ) [FConstants::VIEW_PATH] . DS . $viewInfo ['path'], $layoutPath );
							// Render view.
							ob_start ();
							$viewObject->render ();
							$viewContent = ob_get_clean ();
							// Get info from called controller.
							$actionMessage = $controllerObject->getActionMessages ();
							if ($controllerObject->hasActionErrors ()) {
								$errorCode = "ACTION_ERROR";
								$errorMessage = RequestUtil::getErrorMessage ();
							} else if ($controllerObject->hasFieldErrors ()) {
								$errorMessage = RequestUtil::getFieldErrors ();
								$errorCode = "FIELD_ERROR";
							} else {
								$errorMessage = RequestUtil::getActionMessage ();
								$errorCode = "SUCCESS";
							}
							ob_end_clean ();
							// Return json object.
							echo json_encode ( array (
									'errorCode' => $errorCode,
									'errorMessage' => $errorMessage,
									'content' => json_decode ( $viewContent ) 
							) ); // htmlentities ( $viewContent )
							break;
						case "stream" :
							// Get params.
							$params = $viewInfo ['params'];
							// Get output file name.
							$outputVar = $viewInfo ['output'];
							if (AppUtil::isEmptyString ( $outputVar )) {
								throw new \Exception ( "The output param is not found for action: " . RouteUtil::getRoute ()->getPath () );
							}
							$outputParam = "#{" . $outputVar . "}";
							$outputFileName = "";
							$headers = array ();
							foreach ( $params as $key => $value ) {
								$headerStr = "$key:$value";
								if (false !== strpos ( $headerStr, $outputParam )) {
									$outputFileName = $controllerObject->$outputVar;
									$fileParts = pathinfo ( $outputFileName );
									$headerStr = str_replace ( $outputParam, $fileParts ['basename'], $headerStr );
								}
								$headers [] = $headerStr;
							}
							if (AppUtil::isEmptyString ( $outputFileName )) {
								throw new \Exception ( "The output file [" . $outputFileName . "] is not found" );
							}
							ob_clean ();
							foreach ( $headers as $header ) {
								header ( $header );
							}
							// Get input file name.
							$inputFileName = $viewInfo ['input'];
							if (AppUtil::isEmptyString ( $outputVar )) {
								throw new \Exception ( "The output param is not found for action: " . RouteUtil::getRoute ()->getPath () );
							}
							readfile ( $controllerObject->$inputFileName );
							break;
						case "void" :
							// No process.
							break;
						default :
							// No process.
							break;
					}
				}
			} else {
				if (isset ( $_REQUEST ["rtype"] ) && "json" === $_REQUEST ["rtype"]) {
					// Get info from called controller.
					if ($controllerObject->hasActionErrors ()) {
						$errorCode = "ACTION_ERROR";
						$errorMessage = RequestUtil::getErrorMessage ();
						\DatoLogUtil::error ( $errorMessage );
					} else if ($controllerObject->hasFieldErrors ()) {
						$errorMessage = RequestUtil::getFieldErrors ();
						$errorCode = "FIELD_ERROR";
					} else {
						$errorMessage = RequestUtil::getActionMessage ();
						$errorCode = "SUCCESS";
					}
					// Return JSON object include view content.
					header ( "Content-Type: application/json" );
					echo json_encode ( array (
							'errorCode' => $errorCode,
							'errorMessage' => $errorMessage,
							'content' => '',
							'extra' => $controllerObject->extra 
					) );
				}
			}
		} else {
			throw new \Exception ( 'Method ' . $controllerMethod . ' of class ' . $controllerClass . ' does not exist.' );
		}
	}
}