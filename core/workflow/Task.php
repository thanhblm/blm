<?php

namespace core\workflow;

use core\workflow\ContextBase;

interface Task {
	public function execute(ContextBase &$context);
}