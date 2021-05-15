<?php

namespace common\rule\url\friendly;

use core\interfaces\IRule;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\SessionUtil;

class AliasUrlFriendly implements IRule {
	private $alias;
	private $query;
	public function __construct($alias, $query = "") {
		$this->alias = $alias;
		$this->query = $query;
	}
	public function execute() {
		try {
			$link = $this->alias;
			AppUtil::appendQuery ( $link, $this->query );
			$langCode = SessionUtil::get ( "language.default.code" );
			if (! AppUtil::isEmptyString ( $langCode )) {
				$link = $langCode . "/" . $link;
			}
			return ActionUtil::getFullPathAlias ( $link );
		} catch ( \Exception $e ) {
			\DatoLogUtil::error ( $e->getMessage (), $e );
			return null;
		}
	}
}