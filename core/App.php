<?php

namespace core;

use core\config\ActionConfig;
use core\config\ApplicationConfig;
use core\config\FConstants;
use core\config\FilterConfig;
use core\config\LayoutConfig;
use core\config\ModuleConfig;
use core\filters\FilterChainImp;
use core\utils\AppUtil;
use core\utils\RouteUtil;
use core\workflow\WorkFlowConfig;

require_once ROOT . DS . 'core' . DS . 'libs' . DS . 'lib_integration_config.php';
class App {
	private $splSrcPath;
	private $cliMode= false;
	public static $vdatoProcessId = "";
	public function __construct() {
		$this->splSrcPath = array ();
		$this->splSrcPath [] = ROOT;
		self::$vdatoProcessId = uniqid("VDT");
	}
	public function run(array $cfgs = null) {
		$startTime = round ( microtime ( true ) * 1000 );
		$this->registerAutoLoad ();
		if (! empty ( ApplicationConfig::get ( "default.timezone" ) )) {
			date_default_timezone_set ( ApplicationConfig::get ( "default.timezone" ) );
		}
		$startTime = round ( microtime ( true ) * 1000 );
		$this->init ( "", $cfgs );
		$this->loadModuleConfig ();
		$this->loadModuleSpecificConfig ( RouteUtil::getRoute ()->getModule () );
		
		$this->processFilters ( RouteUtil::getRoute ()->getModule () );
		\DatoLogUtil::logElapedTime("ACTION: " . RouteUtil::getRoute ()->getPath () ,(round ( microtime ( true ) * 1000 ) - $startTime));
	}
	
	public function runCli(array $cfgs , $params = array()) {
		echo  date ( 'Y-m-d H:i:s' )." START ".json_encode($params)."\n";
		$startTime = round ( microtime ( true ) * 1000 );
		if (!is_array($params) || count($params)<4){
			echo  "Invalid arguments, at less [module name, class, method] params required.";
			exit();
		}
		$this->cliMode = true;
		$this->registerAutoLoad ();
		if (! empty ( ApplicationConfig::get ( "default.timezone" ) )) {
			date_default_timezone_set ( ApplicationConfig::get ( "default.timezone" ) );
		}
		$startTime = round ( microtime ( true ) * 1000 );
		$this->init ( "", $cfgs );
		$this->loadModuleConfig ();
		$this->loadModuleSpecificConfig ( $params[1]);
		$objectStr = str_replace ( "/", "\\", $params[2]);
		echo  $objectStr."\n";
		$object  = new $objectStr;
		$method = $params[3];
		$object->$method($params);
		\DatoLogUtil::logElapedTime("CLI EXECUTE: " . $params[1]."|".$params[2]."|".$params[3],(round ( microtime ( true ) * 1000 ) - $startTime));
		echo  date ( 'Y-m-d H:i:s' )." END ".json_encode($params)."\n";
	}
	
	private function init($module = "", array $cfgs = null, $isSpecific = false) {
		if (! empty ( $module ) && (! $isSpecific)) {
			if (! isset ( $cfgs [FConstants::FILTER_CONFIG] )) {
				FilterConfig::setModuleFilters ( $module, FilterConfig::getModuleFilters ( "" ) );
			}
			if (! isset ( $cfgs [FConstants::LAYOUT_CONFIG] )) {
				LayoutConfig::setModuleLayoutConfig ( $module, LayoutConfig::getModuleLayoutConfig ( "" ) );
			}
		}
		
		$redirectScriptFile = null;
		$friendlyScriptFile = null;
		foreach ( $cfgs as $key => $value ) {
			switch ($key) {
				case FConstants::ACTION_CONFIG :
					if (file_exists ( $value )) {
						ActionConfig::addModuleActionMap ( $module, require_once $value );
					} else {
						\DatoLogUtil::error ( $module . " not found: $value" );
					}
					break;
				case FConstants::LAYOUT_CONFIG :
					if (AppUtil::endsWith ( $value, ".php" )) {
						if (file_exists ( $value )) {
							LayoutConfig::setModuleLayoutConfig ( $module, require_once $value );
						} else {
							\DatoLogUtil::error ( $module . " not found: $value" );
						}
					} else {
						LayoutConfig::setModuleLayoutConfig ( $module, LayoutConfig::getModuleLayoutConfig ( $value ) );
					}
					break;
				case FConstants::FILTER_CONFIG :
					if (AppUtil::endsWith ( $value, ".php" )) {
						if (file_exists ( $value )) {
							FilterConfig::setModuleFilters ( $module, require_once $value );
						} else {
							\DatoLogUtil::error ( $module . " not found: $value" );
						}
					} else {
						FilterConfig::setModuleFilters ( $module, FilterConfig::getModuleFilters ( $value ) );
					}
					break;
				case FConstants::MODULE_CONFIG :
					if ($module == "") {
						if (file_exists ( $value )) {
							ModuleConfig::setConfig ( require_once $value );
						} else {
							\DatoLogUtil::error ( $module . " not found: $value" );
						}
						foreach ( ModuleConfig::getModules () as $moduleName => $modConfig ) {
							if (! empty ( $moduleName )) {
								$this->splSrcPath [] = $modConfig [FConstants::MODULE_PATH];
							}
						}
					}
					break;
				case FConstants::WORKFLOW_CONFIG :
					if (file_exists ( $value )) {
						WorkFlowConfig::addConfig ( require_once $value );
					} else {
						\DatoLogUtil::error ( $module . " not found: $value" );
					}
					break;
				case FConstants::FRIENDLY_URL_CONFIG :
					if ($this->cliMode){
						break;
					}
					if ((! empty ( $module ) && ! $isSpecific)) {
						\DatoLogUtil::warn ( "Unsupport friendly url configuration in a specific module default location, please reconfigure in default of app or in specific module configuration location" );
						break;
					}
					if (file_exists ( $value )) {
						$friendlyScriptFile = $value;
					} else {
						\DatoLogUtil::error ( $module . " not found: $value" );
					}
					break;
				case FConstants::REDIRECT_CONFIG :
					if ($this->cliMode){
						break;
					}
					if ((! empty ( $module ) && ! $isSpecific)) {
						\DatoLogUtil::warn ( "Unsupport redirect url configuration in a specific module default location, please reconfigure in default of app or in specific module configuration location" );
						break;
					}
					
					if (file_exists ( $value )) {
						$redirectScriptFile = $value;
					} else {
						\DatoLogUtil::error ( $module . " not found: $value" );
					}
					break;
				default :
					if (file_exists ( $value )) {
						require_once $value;
					} else {
						\DatoLogUtil::error ( $module . " not found: $value" );
					}
					break;
			}
		}
		if (empty ( $module )){
			session_start ();
		}
		if ((empty ( $module ) || $isSpecific)) {
			if (isset ( $friendlyScriptFile ) && ! empty ( $friendlyScriptFile )) {
				$newUri = require_once $friendlyScriptFile;
				if (isset ( $newUri )) {
					$contextPath = ! empty ( ApplicationConfig::get ( 'web.context' ) ) ? ApplicationConfig::get ( 'web.context' ) : "";
					$newUri = $contextPath . "/" . $newUri;
					RouteUtil::setUri ( $newUri );
					$uriInfos = explode ( "?", $newUri );
					if (count ( $uriInfos ) > 1) {
						$queryStr = $uriInfos [1];
						$paramArray = array ();
						parse_str ( $queryStr, $paramArray );
						foreach ( $paramArray as $key => $value ) {
							$_REQUEST [$key] = $value;
						}
					}
					\DatoLogUtil::info("Fiendly url: " . $newUri . " apply to: " . $_SERVER ['REQUEST_URI'] );
				}
			}
			
			if (isset ( $redirectScriptFile ) && ! empty ( $redirectScriptFile )) {
				$redirectUrl = require_once $redirectScriptFile;
				if (isset ( $redirectUrl ) && filter_var ( $redirectUrl, FILTER_VALIDATE_URL )) {
					$redirectUrl = trim ( $redirectUrl );
					while ( AppUtil::endsWith ( $redirectUrl, "?" ) ) {
						$redirectUrl = substr ( $redirectUrl, 0, strlen ( $redirectUrl ) - 1 );
					}
					$urlComponent = parse_url ( $redirectUrl );
					
					$uri = (isset ( $urlComponent ["path"] ) ? $urlComponent ["path"] : "");
					if (isset ( $urlComponent ["query"] ) && ! empty ( $urlComponent ["query"] )) {
						$uri = $uri . "?" . $urlComponent ["query"];
					}
					if ($uri != $_SERVER ['REQUEST_URI']) {
						\DatoLogUtil::info( "Redirect url: " . $redirectUrl . " apply to: " . $_SERVER ['REQUEST_URI'] );
						header ( 'location:' . $redirectUrl );
						exit ();
					}
				}
			}
		}
	}
	private function loadModuleConfig() {
		foreach ( ModuleConfig::getModules () as $key => $value ) {
			if (AppUtil::isEmptyString ( $key )) {
				continue;
			}
			$arr = require_once $value [FConstants::MODULE_PATH] . DS . "loader.php";
			$arrTmp = array ();
			$arrSpecificConfig = array ();
			if (isset ( $arr ) && ! empty ( $arr )) {
				foreach ( $arr as $key1 => $value1 ) {
					if (FConstants::MODULE_SPECIFIC_CONFIG == $key1) {
						if (isset ( $value1 ) && ! empty ( $value1 )) {
							foreach ( $value1 as $key2 => $value2 ) {
								if (AppUtil::endsWith ( $value2, ".php" )) {
									$arrSpecificConfig [$key2] = $value [FConstants::CONFIG_PATH] . DS . $value2;
								} else {
									$arrSpecificConfig [$key2] = $value2;
								}
							}
						}
						continue;
					}
					if (AppUtil::endsWith ( $value1, ".php" )) {
						$arrTmp [$key1] = $value [FConstants::CONFIG_PATH] . DS . $value1;
					} else {
						$arrTmp [$key1] = $value1;
					}
				}
			}
			ModuleConfig::addModuleConfig ( $key, FConstants::COMMON_CONFIG, $arrTmp );
			ModuleConfig::addModuleConfig ( $key, FConstants::SPECIFIC_CONFIG, $arrSpecificConfig );
			$this->init ( $key, $arrTmp );
		}
	}
	private function loadModuleSpecificConfig($module = "") {
		if (! empty ( $module )) {
			if (!is_null(ModuleConfig::getModuleConfig ( $module )) && isset(ModuleConfig::getModuleConfig ( $module ) [FConstants::SPECIFIC_CONFIG])){
				$moduleSpecificConfig = ModuleConfig::getModuleConfig ( $module ) [FConstants::SPECIFIC_CONFIG];
				$this->init ( $module, $moduleSpecificConfig, true );
			}
		}
	}
	
	// Autoloading.
	private function registerAutoLoad() {
		spl_autoload_register ( array (
				__CLASS__,
				'load' 
		) );
	}
	private function processFilters($module = "") {
		$filters = FilterConfig::getModuleFilters ( $module );
		$filterChain = new FilterChainImp ( $filters );
		$filterChain->doFilter ();
	}
	// Define a custom load method.
	private function load($className) {
		$found = false;
		// Toantq-B
		if (DS == "/") {
			$myClassName = str_replace ( "\\", "/", $className ) . '.php';
		} else {
			$myClassName = $className . '.php';
		}
		$overwrite = "vdato";
		foreach ( $this->splSrcPath as $src ) {
			if (file_exists ( $src . DS .$overwrite.DS.$myClassName )) {
				$found = true;
				require_once $src . DS .$overwrite.DS.$myClassName;
				return;
			}
			if (file_exists ( $src . DS . $myClassName )) {
				$found = true;
				require_once $src . DS . $myClassName;
				return;
			}
		}
		if (! $found) {
			$customSpl = ROOT.DS."app".DS."config".DS."spl_loader.php";
			$customParam = array(
					"spl_param_class_name" => $className,
			);
			if (!file_exists()){
				extract ( $customParam);
				include $customSpl;
			}
		}
	}
	private function searchClassFile($class, $dir = null) {
		if (! isset ( $class ) || is_null ( $class )) {
			return false;
		}
		if (DS == "/") {
			$class = str_replace ( "\\", "/", $class );
		}
		
		if (is_null ( $dir )) {
			return false;
		}
		foreach ( scandir ( $dir ) as $file ) {
			// Directory?
			if (is_dir ( $dir . DS . $file ) && substr ( $file, 0, 1 ) !== '.') {
				$result = $this->searchClassFile ( $class, $dir . DS . $file );
				if ($result) {
					return $result;
				}
			}
			// php file?
			if (substr ( $file, 0, 2 ) !== '._' && preg_match ( "/.php$/i", $file )) {
				// Filename matches class?
				// echo str_ireplace ( ROOT . DS, "", $dir . DS . $file ) . "???" . $class . "<br/>";
				$filePath = str_ireplace ( ROOT . DS . $dir . DS, '', $file );
				// \DatoLogUtil::debug('$filePath:' . $filePath . ' == $class:' . $class);
				if ($filePath == $class) {
					$filePath = $dir . DS . $file;
					return $filePath;
				}
			}
		}
		// \DatoLogUtil::debug('3 $class:' . $class . ' $dir:' . $dir);
		return false;
	}
	private function searchModuleClassFile($class, $dir = null) {
		if (! isset ( $class ) || is_null ( $class )) {
			return false;
		}
		if (DS == "/") {
			$class = str_replace ( "\\", "/", $class );
		}
		if (is_null ( $dir )) {
			return false;
		}
		foreach ( scandir ( $dir ) as $file ) {
			// Directory?
			if (is_dir ( $dir . DS . $file ) && substr ( $file, 0, 1 ) !== '.') {
				$result = $this->searchModuleClassFile ( $class, $dir . DS . $file );
				if ($result) {
					return $result;
				}
			}
			// php file?
			if (substr ( $file, 0, 2 ) !== '._' && preg_match ( "/.php$/i", $file )) {
				// Filename matches class?
				$filePath = str_ireplace ( ROOT . DS . $dir . DS, "", $file );
				$startWith = $this->endsWith ( $filePath, $class );
// 				\DatoLogUtil::debug ( "$filePath == $class" );
				if ($filePath == $class) {
					return $dir . DS . $file;
				} else if (! is_null ( $startWith )) {
					if (substr_count ( $startWith, DS ) == 2) {
						return $dir . DS . $file;
					}
				}
			}
		}
		return false;
	}
	private function endsWith($haystack, $needle) {
		$length = strlen ( $needle );
		if ($length == 0) {
			return true;
		}
		if (substr ( $haystack, - $length ) === $needle) {
			return substr ( $haystack, 0, strlen ( $haystack ) - $length );
		} else {
			return null;
		}
	}
}