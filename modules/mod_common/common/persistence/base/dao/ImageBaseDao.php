<?php

namespace common\persistence\base\dao;

use core\database\SqlMapClient;
use core\database\BaseDao;
use common\persistence\base\vo\ImageVo;
use common\persistence\base\mapping\ImageMapping;

class ImageBaseDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	final public function selectByKey(ImageVo $imageVo = null) {
		$result = $this->executeSelectOne ( ImageMapping::class, 'selectByKey', $imageVo );
		return $result;
	}
	final public function selectAll(ImageVo $imageVo = null) {
		$result = $this->executeSelectList ( ImageMapping::class, 'selectAll', $imageVo );
		return $result;
	}
	final public function selectByFilter(ImageVo $imageVo = null) {
		$result = $this->executeSelectList ( ImageMapping::class, 'selectByFilter', $imageVo );
		return $result;
	}
	final public function countByFilter(ImageVo $imageVo = null) {
		$result = $this->executeCount ( ImageMapping::class, 'countByFilter', $imageVo );
		return $result;
	}
	final public function insertDynamic(ImageVo $imageVo = null) {
		$result = $this->executeInsert ( ImageMapping::class, 'insertDynamic', $imageVo );
		return $result;
	}
	final public function insertDynamicWithId(ImageVo $imageVo = null) {
		$result = $this->executeInsert ( ImageMapping::class, 'insertDynamicWithId', $imageVo );
		return $result;
	}
	final public function updateDynamicByKey(ImageVo $imageVo = null) {
		$result = $this->executeUpdate ( ImageMapping::class, 'updateDynamicByKey', $imageVo );
		return $result;
	}
	final public function deleteByKey(ImageVo $imageVo = null) {
		$result = $this->executeDelete ( ImageMapping::class, 'deleteByKey', $imageVo );
		return $result;
	}
}

