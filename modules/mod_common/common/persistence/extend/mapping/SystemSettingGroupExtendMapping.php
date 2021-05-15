<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\SystemSettingGroupVo;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;
use core\utils\SqlMappingUtil;

class SystemSettingGroupExtendMapping {
	private function getCondition(SystemSettingGroupVo $systemSettingGroupVo) {
		$condition = SqlMappingUtil::buildCondition ( $systemSettingGroupVo );
		$condition = str_replace ( " = #{name}", " like #{name}", $condition );
		return $condition;
	}
	public function getByFilter(SystemSettingGroupVo $systemSettingGroupVo) {
		try {
			$query = "select * from system_setting_group";
			// Set dynamic condition.
			$condition = $this->getCondition ( $systemSettingGroupVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if the order by is not null.
			if (! AppUtil::isEmptyString ( $systemSettingGroupVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $systemSettingGroupVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $systemSettingGroupVo->start_record ) && isset ( $systemSettingGroupVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getCountByFilter(SystemSettingGroupVo $systemSettingGroupVo = null) {
		try {
			$query = "select count(*) from system_setting_group";
			if (isset ( $systemSettingGroupVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $systemSettingGroupVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SystemSettingGroupVo::class );
		} catch ( \Exception $e ) {
		}
	}
}