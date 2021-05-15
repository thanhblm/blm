<?php

namespace filemanager\persistence\extend\dao;

use core\database\SqlMapClient;
use filemanager\persistence\base\dao\ImageBaseDao;
use filemanager\persistence\extend\mapping\ImageExtendMapping;
use filemanager\persistence\base\vo\ImageVo;

class ImageExtendDao extends ImageBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function selectByPid(ImageVo $vo) {
		return $this->executeSelectList(ImageExtendMapping::class, 'selectByPid', $vo );
	}
}

