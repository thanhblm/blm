<?php

namespace core\libs\plates\Extension;

use core\libs\plates\Engine;

/**
 * A common interface for extensions.
 */
interface ExtensionInterface
{
    public function register(Engine $engine);
}
