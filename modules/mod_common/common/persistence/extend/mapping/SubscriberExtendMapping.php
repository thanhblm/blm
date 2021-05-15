<?php

namespace common\persistence\extend\mapping;

use common\persistence\extend\vo\SubscriberExtendVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;
use common\persistence\base\vo\SubscriberVo;
use core\database\QueryBuilder;

class SubscriberExtendMapping {
	private function getCondition(SubscriberExtendVo $subscriberVo) {
		$condition = "";
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.id", "id", "=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.email", "email", "like", $condition, ":PARAM_BOTH_LIKE" );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.first_name", "firstName", "like", $condition, ":PARAM_BOTH_LIKE" );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.last_name", "lastName", "like", $condition, ":PARAM_BOTH_LIKE" );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.status", "status", "=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.cr_date", "crDateFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.cr_date", "crDateTo", "<=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.md_date", "mdDateFrom", ">=", $condition );
		SqlMappingUtil::appendFilterIfNotNull ( $subscriberVo, "s.md_date", "mdDateTo", "<=", $condition );
		return $condition;
	}
	public function getByFilter(SubscriberExtendVo $subscriberVo) {
		try {
			$query = "select 
						s.*, 
						cu.user_name as cr_by_name,
						mu.user_name as md_by_name
					from `subscriber` s
					left join `user` cu on cu.id = s.cr_by
					left join `user` mu on mu.id = s.md_by";
			// Set dynamic condition.
			$condition = $this->getCondition ( $subscriberVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $subscriberVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $subscriberVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $subscriberVo->start_record ) && isset ( $subscriberVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SubscriberExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getCountByFilter(SubscriberExtendVo $subscriberVo = null) {
		try {
			$query = "select 
						count(*)
					from `subscriber` s
					left join `user` cu on cu.id = s.cr_by
					left join `user` mu on mu.id = s.md_by";
			if (isset ( $subscriberVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $subscriberVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SubscriberExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getByKey(SubscriberVo $subscriberVo) {
		try {
			$query = "
    		select * from `subscriber`
    		where md5(email) = #{email}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SubscriberVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}