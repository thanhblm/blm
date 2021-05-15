<?php

namespace test\controllers;

use core\Controller;
use test\persistence\base\dao\ProductBaseDao;
use core\BaseArray;
use test\persistence\base\vo\ProductVo;

class ProductController extends Controller {
	public $products;
	public function __construct() {
		$this->products = new BaseArray ( ProductVo::class );
	}
	public function index() {
		$productDao = new ProductBaseDao ();
		$products = $productDao->selectAll ();
		foreach ( $products as $product ) {
			$this->products->add ( $product );
		}
		return "success";
	}
}