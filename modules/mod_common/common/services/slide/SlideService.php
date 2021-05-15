<?php

namespace common\services\slide;

use common\filter\slide\SlideFilter;
use common\persistence\base\vo\SlideVo;
use common\persistence\extend\dao\SlideExtendDao;
use common\persistence\extend\vo\SlideExtendVo;

class SlideService {
	private $extendDao;
	public function __construct() {
		$this->extendDao = new SlideExtendDao ();
	}
	public function selectByKey(SlideVo $vo) {
		return $this->extendDao->selectByKey ( $vo );
	}
	public function selectByFilter(SlideVo $vo) {
		return $this->extendDao->selectByFilter ( $vo );
	}
	public function selectByFilterExtend(SlideExtendVo $vo) {
		return $this->extendDao->selectByFilterExtend( $vo );
	}
	public function countByFilter(SlideVo $vo) {
		return $this->extendDao->countByFilter ( $vo );
	}
	public function delete(SlideVo $vo) {
		return $this->extendDao->delete ( $vo );
	}
	public function createSlide(SlideVo $vo) {
		return $this->extendDao->insertDynamic ( $vo );
	}
	public function updateSlide(SlideVo $vo) {
		$this->extendDao->updateDynamicByKey ( $vo );
	}
	public function search(SlideFilter $filter) {
		return $this->extendDao->search ( $filter );
	}
	public function searchCount(SlideFilter $filter) {
		return $this->extendDao->searchCount ( $filter );
	}
	public function deleteSlide(SlideVo $vo) {
		return $this->extendDao->deleteByKey ( $vo );
	}

    public function getSlideByGroupCode(SlideExtendVo $vo) {
        return $this->extendDao->getSlideByGroupCode( $vo );
    }
}