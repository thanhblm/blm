<?php

namespace common\services\language;

use common\persistence\base\vo\LanguageVo;
use common\persistence\extend\dao\LanguageExtendDao;
use common\persistence\extend\dao\LanguageValueExtendDao;
use common\persistence\base\vo\LanguageValueVo;
use common\persistence\extend\vo\LanguageExtendVo;
use common\persistence\extend\vo\LanguageValueExtendVo;
use core\database\SqlMapClient;

class LanguageService {
	private $languageDao;
	private $languageValueDao;
	public function __construct() {
		$this->languageDao = new LanguageExtendDao ();
		$this->languageValueDao = new LanguageValueExtendDao ();
	}
	public function getLanguageByCode(LanguageVo $filter) {
		return $this->languageDao->selectByKey ( $filter );
	}
	public function getLanguageByFilter(LanguageExtendVo $filter) {
		return $this->languageDao->getByFilter ( $filter );
	}
	public function countLanguageByFilter(LanguageExtendVo $filter) {
		return $this->languageDao->getCountByFilter ( $filter );
	}
	public function addLanguage(LanguageVo $languageVo) {
		$context = array ();
		// Create new transaction.
		$sqlClient = new SqlMapClient ( $context );
		$languageDao = new LanguageExtendDao ( $context, $sqlClient );
		$languageValueDao = new LanguageValueExtendDao ( $context, $sqlClient );
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// Add new language.
			$return = $languageDao->insertDynamic ( $languageVo );
			/*
			// Delete all language values of new language.
			$oldLanguageFilter = new LanguageValueExtendVo();
			$oldLanguageFilter->languageCode = $languageVo->code;
			$languageValueDao->deleteLanguageValueByCode($oldLanguageFilter);
			*/
			// Copy all language values of EN to new language.
			// not include exists key.
			$filter = new LanguageValueExtendVo ();
			$filter->newLanguageCode = $languageVo->code;
			$filter->languageCode = 'en';
			$filter->crDate = $languageVo->crDate;
			$filter->crBy = $languageVo->crBy;
			$filter->mdDate = $languageVo->mdDate;
			$filter->mdBy = $languageVo->mdBy;
			$languageValueDao->copyLanguageValueByCode ( $filter );
			// Commit transaction.
			$sqlClient->endTransaction ();
			return $return;
		} catch ( \Exception $e ) {
			// Rollback transaction.
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function updateLanguage(LanguageVo $languageVo) {
		return $this->languageDao->updateDynamicByKey ( $languageVo );
	}
	public function deleteLanguage(LanguageVo $languageVo) {
		return $this->languageDao->deleteByKey ( $languageVo );
	}
	public function getAllLanguages() {
		return $this->languageDao->selectAll ();
	}
	public function getLanguageValueById(LanguageValueVo $filter) {
		return $this->languageValueDao->selectByKey ( $filter );
	}
	public function getLanguageValueByFilter(LanguageValueExtendVo $filter) {
		return $this->languageValueDao->getByFilter ( $filter );
	}
	public function countLanguageValueByFilter(LanguageValueExtendVo $filter) {
		return $this->languageValueDao->getCountByFilter ( $filter );
	}
	public function updateLanguageValue(LanguageValueVo $languageValueVo) {
		return $this->languageValueDao->updateDynamicByKey ( $languageValueVo );
	}
}