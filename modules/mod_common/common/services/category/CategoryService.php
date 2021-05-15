<?php

namespace common\services\category;

use common\persistence\base\vo\CategoryVo;
use common\persistence\extend\dao\CategoryExtendDao;
use common\persistence\extend\vo\CategoryExtendVo;

class CategoryService {
	private $contactDao;
	public function __construct() {
		$this->contactDao = new CategoryExtendDao ();
	}
	public function getAll() {
		return $this->contactDao->selectAll ();
	}
	public function selectByFilter(CategoryExtendVo $filter) {
		return $this->contactDao->selectByFilter( $filter );
	}
	public function countByFilter(CategoryExtendVo $filter) {
		return $this->contactDao->countByFilter($filter );
	}
	public function add(CategoryVo $contactVo) {
		return $this->contactDao->insertDynamic ( $contactVo );
	}
	public function update(CategoryVo $contactVo) {
		return $this->contactDao->updateDynamicByKey ( $contactVo );
	}
	public function delete(CategoryVo $contactVo) {
		return $this->contactDao->deleteByKey ( $contactVo );
	}
	public function selectByKey(CategoryVo $contactVo) {
		return $this->contactDao->selectByKey($contactVo );
	}
}