<?php

namespace filemanager\services\filemanager;

use filemanager\persistence\base\vo\ImageVo;
use filemanager\persistence\extend\dao\ImageExtendDao;

class ImageService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new ImageExtendDao();
	}
	public function selectByKey(ImageVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByPid(ImageVo $vo) {
		return $this->extendDao->selectByPid ( $vo );
	}
	public function selectByFilter(ImageVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function createImage(ImageVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function updateDynamicByKey(ImageVo $vo) {
		return $this->extendDao->updateDynamicByKey ( $vo );
	}
}