<?php

namespace common\workflow\mydemo;

use core\workflow\Task;
use core\workflow\ContextBase;

class Test2Task implements Task{
	public function execute(ContextBase &$context){
		$context->set ( "Test2Task", Test2Task::class );
		//return false;
	}
	
}