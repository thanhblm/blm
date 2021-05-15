<?php

namespace common\persistence\extend\dao;
use core\database\BaseDao;
use core\database\SqlMapClient;
use common\persistence\base\vo\ContainerVo;
use common\persistence\extend\mapping\ContainerExtendMapping;

class ContainerExtendDao extends BaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}

	public function getGridListOfContainer(ContainerVo $containerVo) {
		return $this->executeSelectList ( ContainerExtendMapping::class, 'getGridListOfContainer', $containerVo );
	}

	public function deleteByFilter(ContainerVo $filter = null) {
		$result = $this->executeDelete ( ContainerExtendMapping::class, 'deleteByFilter', $filter );
		return $result;
	}

	public function getContainerByPageId($pageId){
        return $this->executeSelectOne(ContainerExtendMapping::class, 'getContainerByPageId', $pageId );
    }


	/**
	 * ***************************
	 * ADVANCE
	 * ***************************
	 */

	/*****************************
	 * FILTER
	 *****************************/
	public function getContainerByFilter(ContainerVo $filter = null) {
		$result = $this->executeSelectList ( ContainerExtendMapping::class, 'getContainerByFilter', $filter );
		return $result;
	}
	public function getCountByFilter(ContainerVo $filter = null) {
		$result = $this->executeCount ( ContainerExtendMapping::class, 'getCountByFilter', $filter );
		return $result;
	}
}