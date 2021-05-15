<?php

namespace common\persistence\extend\dao;

use common\persistence\base\dao\BlockEmailBaseDao;
use common\persistence\base\vo\BlockEmailVo;
use common\persistence\extend\mapping\BlockEmailExtendMapping;
use core\database\SqlMapClient;

class BlockEmailExtendDao extends BlockEmailBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	/*public function getByName(BlockEmailVo $BlockEmailVo) {
		$filter = new BlockEmailVo ();
		$filter->name = $BlockEmailVo->name;
		$result = $this->executeSelectOne ( BlockEmailExtendMapping::class, 'getByName', $filter );
		return $result;
	}*/
	public function getByFilter(BlockEmailVo $BlockEmailVo = null) {
		$result = $this->executeSelectList ( BlockEmailExtendMapping::class, 'getByFilter', $BlockEmailVo );
		return $result;
	}
	public function getCountByFilter(BlockEmailVo $BlockEmailVo = null) {
		$result = $this->executeCount ( BlockEmailExtendMapping::class, 'getCountByFilter', $BlockEmailVo );
		return $result;
	}
	public function getBlockEmailByEmail(BlockEmailVo $BlockEmailVo = null) {
		$result = $this->executeSelectList ( BlockEmailExtendMapping::class, 'getBlockEmailByEmail', $BlockEmailVo );
		return $result;
	}
}