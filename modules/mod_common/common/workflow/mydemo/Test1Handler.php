<?php

namespace common\workflow\mydemo;

use core\workflow\Handler;
use core\workflow\ContextBase;

class Test1Handler extends Handler {
	public function handle(ContextBase &$context, \Exception $exception = null) {
		$context->set ( "Test1Handler", Test1Handler::class );
	}
}