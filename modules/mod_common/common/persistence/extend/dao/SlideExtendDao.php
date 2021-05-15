<?php

namespace common\persistence\extend\dao;

use common\filter\slide\SlideFilter;
use common\persistence\base\dao\SlideBaseDao;
use common\persistence\base\vo\SlideVo;
use common\persistence\extend\mapping\SlideExtendMapping;
use common\persistence\extend\vo\SlideExtendVo;
use core\database\SqlMapClient;

class SlideExtendDao extends SlideBaseDao {
	public function __construct(array $addInfo = null, SqlMapClient $sqlMapClient = null) {
		parent::__construct ( $addInfo, $sqlMapClient );
	}
	public function search(SlideFilter $filter) {
		$result = $this->executeSelectList ( SlideExtendMapping::class, 'search', $filter );
		return $result;
	}
	
	public function searchCount(SlideFilter $filter) {
		$result = $this->executeCount( SlideExtendMapping::class, 'searchCount', $filter );
		return $result;
	}
	public function delete(SlideVo $slideVo) {
		$result = $this->executeDelete( SlideExtendMapping::class, 'delete', $slideVo);
		return $result;
	}
	public function selectByFilterExtend(SlideVo $slideVo = null) {
		$result = $this->executeSelectList ( SlideExtendMapping::class, 'selectByFilterExtend', $slideVo );
		return $result;
	}

    public function getSlideByGroupCode(SlideExtendVo $slideVo = null) {
        $result = $this->executeSelectList ( SlideExtendMapping::class, 'getSlideByGroupCode', $slideVo );
        return $result;
    }


}