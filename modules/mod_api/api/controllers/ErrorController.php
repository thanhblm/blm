<?php

namespace api\controllers;


use core\Controller;

/**
 *
 * @author System
 *        
 */
class ErrorController extends Controller {
	public function __construct() {
		parent::__construct ();
	}
	public function error404() {
		return "success";
	}
}