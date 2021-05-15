<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\SystemSettingVo;
use core\database\SqlStatementInfo;
use core\utils\SqlMappingUtil;
use core\utils\AppUtil;

class SystemSettingExtendMapping {
	private function getCondition(SystemSettingVo $systemSettingVo) {
		$condition = SqlMappingUtil::buildCondition ( $systemSettingVo );
		$condition = str_replace ( " = #{name}", " like #{name}", $condition );
		return $condition;
	}
	public function getByName(SystemSettingVo $systemSettingVo) {
		try {
			$query = "select * from system_setting where `name` = #{name}";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getByFilter(SystemSettingVo $systemSettingVo) {
		try {
			$query = "select * from system_setting";
			// Set dynamic condition.
			$condition = $this->getCondition ( $systemSettingVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $systemSettingVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $systemSettingVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $systemSettingVo->start_record ) && isset ( $systemSettingVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getCountByFilter(SystemSettingVo $systemSettingVo = null) {
		try {
			$query = "select count(*) from system_setting";
			if (isset ( $systemSettingVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $systemSettingVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingVo::class );
		} catch ( \Exception $e ) {
		}
	}
}