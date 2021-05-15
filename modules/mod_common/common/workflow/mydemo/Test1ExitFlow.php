<?php

namespace common\workflow\mydemo;

use core\workflow\ExitFlow;
use core\workflow\ContextBase;

class Test1ExitFlow extends ExitFlow {
	public function process(ContextBase &$context) {
		$context->set ( "Test1ExitFlow", Test1ExitFlow::class );
	}
}