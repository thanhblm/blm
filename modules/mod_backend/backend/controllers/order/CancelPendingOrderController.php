<?php


namespace backend\controllers\order;


use common\config\Attributes;
use common\config\ErrorCodes;
use core\Controller;
use core\workflow\ContextBase;
use core\workflow\WorkflowManager;

class CancelPendingOrderController extends Controller {

	public function __construct(){
		parent::__construct();
	}

	public function cancelPendingOrder(){
		$context = new ContextBase();
		WorkflowManager::Instance()->execute("wfl_cancel_pending_order", $context);
		if ($context->get(Attributes::ATTR_ERROR_CODE) === ErrorCodes::ERROR) {
			throw new \Exception($context->get(Attributes::ATTR_ERROR_MESSAGE));
		}
	}
}