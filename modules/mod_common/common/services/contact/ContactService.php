<?php

namespace common\services\contact;

use common\persistence\base\vo\ContactVo;
use common\persistence\extend\dao\ContactExtendDao;
use common\persistence\extend\vo\ContactExtendVo;

class ContactService {
	private $contactDao;
	public function __construct() {
		$this->contactDao = new ContactExtendDao ();
	}
	public function getAll() {
		return $this->contactDao->selectAll ();
	}
	public function getByFilter(ContactExtendVo $filter) {
		return $this->contactDao->getByFilter ( $filter );
	}
	public function getCountByFilter(ContactExtendVo $filter) {
		return $this->contactDao->getCountByFilter ( $filter );
	}
	public function add(ContactVo $contactVo) {
		return $this->contactDao->insertDynamic ( $contactVo );
	}
	public function update(ContactVo $contactVo) {
		return $this->contactDao->updateDynamicByKey ( $contactVo );
	}
	public function delete(ContactVo $contactVo) {
		return $this->contactDao->deleteByKey ( $contactVo );
	}
	public function getById(ContactVo $contactVo) {
		return $this->contactDao->getById ( $contactVo );
	}
}