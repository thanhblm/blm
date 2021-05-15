<?php

namespace common\workflow\aliexpress_import_product;

use core\workflow\ContextBase;
use core\workflow\Handler;

class AliexpressImportProductHandler extends Handler {
	public function handle(ContextBase &$context, \Exception $exception = null) {
		$actionErrors = $context->get("actionErrors");
		$actionErrors[] = $exception;
		$context->set("actionErrors", $actionErrors);
	}
}