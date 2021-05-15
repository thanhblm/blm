<?php

namespace core\template\html\base;

use core\config\ApplicationConfig;
use core\utils\AppUtil;
use common\helper\PermissionHelper;

abstract class HtmlElement {
	protected $template;
	public $attributes = "";
	public $id = "";
	public $name = "";
	private $templateFile = "";
	public $isShow = true;
	public $checkActionPath = null;
	public function __construct($template = null, $id = null, $attributes = null) {
		$this->id = AppUtil::defaultIfEmpty( $id );
		$this->attributes = AppUtil::defaultIfEmpty( $attributes );
		$this->template = AppUtil::defaultIfEmpty( $template );
	}
	abstract protected function getDefaultTemplate();
	public function render() {
		if (empty($this->id)){
			if (!empty($this->name)){
				$this->id = "id_".$this->name;
				$this->id = str_replace("[", "_", $this->id);
				$this->id = str_replace("]", "_", $this->id);
			}
		}else{
			$this->id = str_replace("[", "_", $this->id);
			$this->id = str_replace("]", "_", $this->id);
		}
		if (!empty($this->id) && AppUtil::endsWith($this->id, "_")){
			$this->id = substr($this->id, 0,strlen($this->id)-1);
		}
		if (empty ( $this->template )) {
			$templateFile = dirname ( __FILE__ ) . DS . "default" . DS . $this->getDefaultTemplate () . ".php";
		} else {
			$templateFile = ApplicationConfig::get ( "html.template.path" ) . DS . $this->template . ".php";
		}
		if (file_exists ( $templateFile )) {
			extract ( ( array ) $this );
			$sourceElement = $this;
			if ($isShow && ( is_null($checkActionPath) || PermissionHelper::hasAdminPermission($checkActionPath))){
				include $templateFile;
			}
		} else {
			throw new \Exception ( "template is not existed in " . $templateFile );
		}
	}
	
}