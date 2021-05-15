<?php

namespace common\services\manufacture;

use common\filter\manufacture\ManufactureFilter;
use common\persistence\base\vo\ManufactureVo;
use common\persistence\extend\dao\ManufactureExtendDao;
use common\persistence\extend\vo\ManufactureExtendVo;

class ManufactureService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new ManufactureExtendDao ();
	}
	public function selectByKey(ManufactureVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(ManufactureVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function countByFilter(ManufactureVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function delete(ManufactureVo $vo) {
		return $this->extendDao->deleteByKey( $vo );
	}
	public function createManufacture(ManufactureVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function updateManufacture(ManufactureVo $vo) {
		$this->extendDao->updateDynamicByKey ( $vo );
	}
	public function search(ManufactureFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(ManufactureFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
}