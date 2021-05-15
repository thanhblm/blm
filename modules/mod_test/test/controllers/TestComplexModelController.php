<?php

namespace test\controllers;

use core\Controller;
use test\model\ProductModel;

class TestComplexModelController extends Controller {
	public $product;
	public function __construct() {
		parent::_construct ();
		$this->product = new ProductModel ();
	}
	public function index() {
		return "success";
	}
	public function add() {
		var_dump ( $this->product );
		return "success";
	}
}