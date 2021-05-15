<?php

namespace frontend\controllers;

use frontend\controllers\FrontendController;

/**
 *
 * @author System
 *        
 */
class ErrorController extends FrontendController {
	public function __construct() {
		parent::__construct ();
	}
	public function error404() {
		return "success";
	}
}