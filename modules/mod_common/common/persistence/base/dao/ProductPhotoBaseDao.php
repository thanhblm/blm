<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ProductPhotoVo;
use common\persistence\base\mapping\ProductPhotoMapping;

class ProductPhotoBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeSelectOne ( ProductPhotoMapping::class, 'selectByKey', $productPhotoVo );
		return $result;
	}
	final public function selectAll(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeSelectList ( ProductPhotoMapping::class, 'selectAll', $productPhotoVo );
		return $result;
	}
	final public function selectByFilter(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeSelectList ( ProductPhotoMapping::class, 'selectByFilter', $productPhotoVo );
		return $result;
	}
	final public function countByFilter(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeCount ( ProductPhotoMapping::class, 'countByFilter', $productPhotoVo );
		return $result;
	}
	final public function insertDynamic(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeInsert ( ProductPhotoMapping::class, 'insertDynamic', $productPhotoVo );
		return $result;
	}
	final public function updateDynamicByKey(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeUpdate ( ProductPhotoMapping::class, 'updateDynamicByKey', $productPhotoVo );
		return $result;
	}
	final public function deleteByKey(ProductPhotoVo $productPhotoVo = null) {
		$result = $this->executeDelete ( ProductPhotoMapping::class, 'deleteByKey', $productPhotoVo );
		return $result;
	}
}

