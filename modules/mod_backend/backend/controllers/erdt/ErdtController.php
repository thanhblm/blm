<?php

namespace backend\controllers\erdt;

use common\config\Attributes;
use common\config\ErrorCodes;
use core\Controller;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;

class ErdtController extends Controller {

	public $inputFilePath;
	public $outputFileName;

	public function __construct(){
		parent::__construct();
	}

	public function erdtUpload(){
		$context = new ContextBase();
		WorkflowManager::Instance()->execute("wfl_erdt_upload", $context);
		if ($context->get(Attributes::ATTR_ERROR_CODE) === ErrorCodes::ERROR) {
			throw new \Exception($context->get(Attributes::ATTR_ERROR_MESSAGE));
		}
	}

	public function erdtExport(){
		$context = new ContextBase();
		WorkflowManager::Instance()->execute("wfl_erdt_export", $context);
		\DatoLogUtil::devInfo($context);
		if ($context->get(Attributes::ATTR_ERROR_CODE) === ErrorCodes::ERROR) {
			throw new \Exception($context->get(Attributes::ATTR_ERROR_MESSAGE));
		}else{
			$this->inputFilePath = $context->get(Attributes::FILE_PATH);
			$this->outputFileName = $context->get(Attributes::FILE_NAME);
		}
		return "success";
	}
}