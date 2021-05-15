<?php

namespace common\services\country;

use common\persistence\base\dao\CountryBaseDao;
use common\services\base\BaseService;
use common\persistence\base\vo\CountryVo;

class CountryService extends  BaseService{
	private $countryDao;
	public function __construct() {
		$this->countryDao = new CountryBaseDao ();
	}
	public function selectByKey(CountryVo $vo) {
		return $this->countryDao->selectByKey ( $vo );
	}
	public function selectByFilter(CountryVo $vo){
		return $this->countryDao->selectByFilter( $vo );
	}
	public function countByFilter(CountryVo $vo){
		return $this->countryDao->countByFilter( $vo );
	}
	public function getAll() {
		return $this->countryDao->selectAll ();
	}
}