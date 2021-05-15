<?php

namespace backend\controllers\media;

use core\Controller;

class ImageController extends Controller {
	public $imageUrl;
	public $index;
	function __construct() {
		parent::__construct ();
	}
	public function addImageAjax() {
		$this->index = uniqid ();
		return "success";
	}
}