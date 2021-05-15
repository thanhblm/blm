<?php

namespace core;

use common\persistence\base\dao\LanguageBaseDao;
use common\persistence\base\dao\LanguageValueBaseDao;
use common\persistence\base\vo\LanguageValueVo;
use core\config\ApplicationConfig;
use core\utils\SessionUtil;

class Dictionary {
	private $languageDao;
	private $languageValueDao;
	public function __construct() {
		$this->languageDao = new LanguageBaseDao ();
		$this->languageValueDao = new LanguageValueBaseDao ();
	}
	public function get($langCode, $key) {
		// Normalize lang code and key.
		$lookupLangCode = $this->normalizeLangCode ( $langCode, "en" );
		$lookupKey = $this->normalizeKey ( $key );
		$myLookupKey = md5 ( $lookupKey );
		// Check lang code and key.
		$result = null;
		$languagValueCache = $this->getLanguageValueData ( $lookupLangCode );
		
		if (isset ( $languagValueCache [$myLookupKey] )) {
			$result = $languagValueCache [$myLookupKey];
		}
		
		if (is_null ( $result )) {
			try {
				$languageCodes = $this->getLanguageCodes ( $lookupLangCode );
				foreach ( $languageCodes as $languageCode ) {
					$languageVo = $this->getLanguageValue ( $this->normalizeKey ( $languageCode ), $lookupKey );
					if (is_null ( $languageVo )) {
						// Insert new language if it doesn't exist.
						\DatoLogUtil::warn ( "not found translation for:" . $key . "| going to update translation data." );
						$this->insert ( $languageCode, $lookupKey, $key );
					} else {
						if ($this->normalizeKey ( $languageCode ) === $lookupLangCode){
							$result = $languageVo->destination;
						}
					}
				}
				$this->reload ( $lookupLangCode );
				if (is_null ( $result )) {
					$result = $key;
				}
				return $result;
			} catch ( \Exception $e ) {
				\DatoLogUtil::error ( $e->getMessage (), $e );
				return $key;
			}
		}
		return $result;
	}
	protected function insert($langCode, $key, $value) {
		// Create new language vo.
		$languageValueVo = new LanguageValueVo ();
		$languageValueVo->key = md5 ( $key );
		$languageValueVo->languageCode = $langCode;
		$languageValueVo->original = $key;
		$languageValueVo->destination = $value;
		$languageValueVo->crBy = 0;
		$languageValueVo->crDate = date ( 'Y-m-d H:i:s' );
		$languageValueVo->mdBy = 0;
		$languageValueVo->mdDate = date ( 'Y-m-d H:i:s' );
		// Insert language vo into the database.
		$this->languageValueDao->insertDynamic ( $languageValueVo );
	}
	protected function normalizeLangCode($langCode, $default = "en") {
		return ! isset ( $langCode ) ? $default : strtolower ( trim ( $langCode ) );
	}
	protected function normalizeKey($key, $default = "") {
		return ! isset ( $key ) ? $default : trim ( $key );
	}
	protected function getLanguageCodes($langCode) {
		$languageCodes = array ();
		$languageCodes [] = $langCode;
		$languageVos = $this->languageDao->selectAll ();
		if (! empty ( $languageVos )) {
			foreach ( $languageVos as $languageVo ) {
				if ($languageVo->code !== $langCode) {
					$languageCodes [] = $languageVo->code;
				}
			}
		}
		return $languageCodes;
	}
	protected function getLanguageValue($langCode, $key) {
		// Get language from the database.
		$filter = new LanguageValueVo ();
		$filter->languageCode = $langCode;
		$filter->key = md5 ( $key );
		$languageVos = $this->languageValueDao->selectByFilter ( $filter );
		// Check existing of language.
		if (isset ( $languageVos ) && ! empty ( $languageVos )) {
			return $languageVos [0];
		}
		return null;
	}
	protected function getLanguageValueData($lookupLangCode) {
		$languageValueCache = SessionUtil::get ( ApplicationConfig::get ( "cache.language.value.name" ) );
		$result = array ();
		if (is_null ( $languageValueCache ) || ! isset ( $languageValueCache [$lookupLangCode] )) {
			$languageValueCache = self::reload ( $lookupLangCode );
		}
		
		if (is_null ( $languageValueCache ) || ! isset ( $languageValueCache [$lookupLangCode] )) {
			$languageValueCache = array ();
		} else {
			$result = $languageValueCache [$lookupLangCode];
		}
		return $result;
	}
	public function reload($lookupLangCode) {
		$filter = new LanguageValueVo ();
		$filter->languageCode = $lookupLangCode;
		$languaValueVos = $this->languageValueDao->selectByFilter ( $filter );
		$languageValueCache = array ();
		foreach ( $languaValueVos as $languaValueVo ) {
			$languageValueCache [$lookupLangCode] [$languaValueVo->key] = $languaValueVo->destination;
		}
		SessionUtil::set ( ApplicationConfig::get ( "cache.language.value.name" ), $languageValueCache );
		return $languageValueCache;
	}
}