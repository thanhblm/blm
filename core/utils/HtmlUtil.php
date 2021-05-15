<?php

namespace core\utils;

use core\libs\plates\Engine;

class HtmlUtil {
	public static function createHtml($data = null, $templatePath, $templateName, $fileOutputPath) {
		$template = new Engine ( $templatePath );
		$htmldata = $template->render ( $templateName );
		file_put_contents ( $fileOutputPath, $htmldata );
	}
}