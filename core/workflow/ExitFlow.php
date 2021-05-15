<?php

namespace core\workflow;

use core\workflow\ContextBase;

abstract class ExitFlow implements Task {
	public function execute(ContextBase &$context) {
		return true;
	}
	public abstract function process(ContextBase &$context);
}