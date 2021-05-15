<?php

namespace common\workflow\mydemo;

use core\workflow\Task;
use core\workflow\ContextBase;

class Test1Task implements Task{
	public function execute(ContextBase &$context){
		$context->set ( "Test1Task", Test1Task::class );
		\DatoLogUtil::info(" my name is ".get_class($this));
	}
	
}