<?php

namespace backend\controllers\shipchung;

use core\PagingController;

/**
 * *
 *
 * @author TANDT
 *        
 */
class TrackingController extends PagingController {

	public function __construct() {
		parent::__construct ();
	}
	public function tracking(){
		return "success";
	}

}