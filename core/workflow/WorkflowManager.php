<?php

namespace core\workflow;

use core\workflow\ContextBase;
use core\config\FAttributes;

class WorkflowManager {
	public static function Instance() {
		static $inst = null;
		if (is_null($inst)) {
			$inst = new WorkflowManager ();
		}
		return $inst;
	}
	private function __construct() {
	}
	public function execute($wfpName, ContextBase &$context = null) {
		$context = isset ( $context ) ? $context : new  ContextBase();
		$context->set(FAttributes::ATTR_WFP_NAME,$wfpName);
		$flow = new Flow();
		$flow->execute($context);
	}
}