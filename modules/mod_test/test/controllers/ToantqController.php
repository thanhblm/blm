<?php

namespace test\controllers;

use common_lib\persistence\base\vo\ProductVo;
use core\Controller;
use core\utils\AppUtil;

class ToantqController extends Controller {
	public function __construct() {
	}
	public function index() {
		$arrSrc = array ();
		
		$productVo = new ProductVo ();
		$productVo->name = "test";
		$arrSrc [] = $productVo;
		$productVo1 = new ProductVo ();
		$productVo1->name = "test1";
		$arrSrc [] = $productVo1;
		echo "<br>------------- Clone productVo1 --------------<br>";
		var_dump ( AppUtil::cloneObj ( $productVo1 ) );
		echo "<br>------------- Clone arrSrc ------------------------<br>";
		var_dump ( AppUtil::cloneObj ( $arrSrc ) );
		
		return "success";
	}
}