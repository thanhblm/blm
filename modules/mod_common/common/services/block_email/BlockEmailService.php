<?php

namespace common\services\block_email;

use common\persistence\extend\dao\BlockEmailExtendDao;
use common\persistence\base\vo\BlockEmailVo;

class BlockEmailService {
	private $BlockEmailDao;
	public function __construct() {
		$this->BlockEmailDao = new BlockEmailExtendDao ();
	}
	public function getBlockEmailByKey(BlockEmailVo $filter) {
		return $this->BlockEmailDao->selectByKey ( $filter );
	}
	public function getBlockEmailByFilter(BlockEmailVo $filter) {
		return $this->BlockEmailDao->getByFilter ( $filter );
	}
	public function countBlockEmailByFilter(BlockEmailVo $filter) {
		return $this->BlockEmailDao->getCountByFilter ( $filter );
	}
	public function addBlockEmail(BlockEmailVo $filter) {
		return $this->BlockEmailDao->insertDynamic ( $filter );
	}
	public function updateBlockEmail(BlockEmailVo $filter) {
		return $this->BlockEmailDao->updateDynamicByKey ( $filter );
	}
	public function deleteBlockEmail(BlockEmailVo $filter) {
		return $this->BlockEmailDao->deleteByKey ( $filter );
	}
	public function getAll() {
		return $this->BlockEmailDao->selectAll ();
	}
	public function getBlockEmailByEmail(BlockEmailVo $filter) {
		return $this->BlockEmailDao->getBlockEmailByEmail ( $filter );
	}
}