<?php

namespace api\controllers\aliexpress;

use api\common\AliexpressConstants;
use core\Controller;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;

class AliexpressController extends Controller{
	public $url;
	public function importProduct(){
		$this->url = "https://www.aliexpress.com/item/Lenovo-TAB4-8-Plus-Android-7-1-Tablet-PC-8-inch-APQ8053-Octa-Core-2-0GHz/32841426714.html";
		if(isset($this->url)){
			$html = file_get_contents($this->url);
			$context = new ContextBase();
			$context->set(AliexpressConstants::ALIEXPRESS_PRODUCT_DETAIL_HTML, $html);
			\DatoLogUtil::devInfo($html);
			WorkflowManager::Instance()->execute(AliexpressConstants::ALIEXPRESS_PRODUCT_IMPORT_WFL, $context);
			\DatoLogUtil::devInfo($context);
			$actionErrors = $context->get("actionErrors");
			$fieldErrors = $context->get("fieldErrors");
			foreach ($actionErrors as $actionError) {
				$this->addActionError($actionError);
			}
			foreach ($fieldErrors as $field => $errorMessage) {
				$this->addFieldError($field, $errorMessage [0]);
			}
		}
		return "success";
	}
	public function checkSession(){
		return "success";
	}

}