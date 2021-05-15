<?php

namespace core\workflow;

use core\workflow\ContextBase;

abstract class Handler implements Task {
	public function execute(ContextBase &$context) {
		return true;
	}
	public abstract function handle(ContextBase &$context,\Exception $exception);
}