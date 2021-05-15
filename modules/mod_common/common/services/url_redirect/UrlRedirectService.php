<?php

namespace common\services\url_redirect;

use common\persistence\base\vo\UrlRedirectVo;
use common\persistence\extend\dao\UrlRedirectExtendDao;
use common\persistence\extend\vo\UrlRedirectExtendVo;

class UrlRedirectService {
	private $urlRedirectDao;
	public function __construct() {
		$this->urlRedirectDao = new UrlRedirectExtendDao ();
	}
	public function getAll() {
		return $this->urlRedirectDao->selectAll ();
	}
	public function getByFilter(UrlRedirectExtendVo $filter) {
		return $this->urlRedirectDao->getByFilter ( $filter );
	}
	public function getCountByFilter(UrlRedirectExtendVo $filter) {
		return $this->urlRedirectDao->getCountByFilter ( $filter );
	}
	public function add(UrlRedirectVo $urlRedirectVo) {
		return $this->urlRedirectDao->insertDynamic ( $urlRedirectVo );
	}
	public function update(UrlRedirectVo $urlRedirectVo) {
		return $this->urlRedirectDao->updateDynamicByKey ( $urlRedirectVo );
	}
	public function delete(UrlRedirectVo $urlRedirectVo) {
		return $this->urlRedirectDao->deleteByKey ( $urlRedirectVo );
	}
	public function getById(UrlRedirectVo $urlRedirectVo) {
		return $this->urlRedirectDao->selectByKey ( $urlRedirectVo );
	}
	public function getByOldUrl(UrlRedirectExtendVo $urlRedirectVo) {
		return $this->urlRedirectDao->selectByFilter ( $urlRedirectVo );
	}
}