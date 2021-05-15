<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\emailTemplateVo;
use common\persistence\extend\vo\EmailTemplateExtendVo;
use core\database\SqlStatementInfo;
use core\utils\SqlMappingUtil;
use core\utils\AppUtil;

class EmailTemplateExtendMapping {
	private function getCondition(EmailTemplateExtendVo $emailTemplateVo) {
		$condition = SqlMappingUtil::buildCondition ( $emailTemplateVo );
		$condition = str_replace ( " = #{title}", " like #{title:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{subject}", " like #{subject:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{sendTo}", " like #{sendTo:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{from}", " like #{from:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{to}", " like #{to:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{reply}", " like #{reply:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{cc}", " like #{cc:PARAM_BOTH_LIKE}", $condition );
		$condition = str_replace ( " = #{bcc}", " like #{bcc:PARAM_BOTH_LIKE}", $condition );
		/*
		 * SqlMappingUtil::appendFilterIfNotNull ( $emailTemplateVo, "et.cr_date", "crDateFrom", ">=", $condition );
		 * SqlMappingUtil::appendFilterIfNotNull ( $emailTemplateVo, "et.cr_date", "crDateTo", "<=", $condition );
		 * SqlMappingUtil::appendFilterIfNotNull ( $emailTemplateVo, "et.md_date", "mdDateFrom", ">=", $condition );
		 * SqlMappingUtil::appendFilterIfNotNull ( $emailTemplateVo, "et.md_date", "mdDateTo", "<=", $condition );
		 */
		return $condition;
	}
	public function getByFilter(EmailTemplateExtendVo $emailTemplateVo) {
		try {
			$query = "select et.* from `email_template` et ";
			// Set dynamic condition.
			$condition = $this->getCondition ( $emailTemplateVo );
			if (! AppUtil::isEmptyString ( $condition )) {
				$query .= " where " . $condition;
			}
			// Set order if theZ order by is not null.
			if (! AppUtil::isEmptyString ( $emailTemplateVo->order_by )) {
				$query .= " order by " . SqlMappingUtil::buildOrderByClause ( $emailTemplateVo );
			}
			// Set limit if start_record & end_record is not null.
			if (isset ( $emailTemplateVo->start_record ) && isset ( $emailTemplateVo->end_record )) {
				$query .= " limit #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, EmailTemplateExtendVo::class );
		} catch ( \Exception $e ) {
		}
	}
	public function getCountByFilter(EmailTemplateExtendVo $emailTemplateVo = null) {
		try {
			$query = "select count(*) from `email_template` et ";
			if (isset ( $emailTemplateVo )) {
				// Set dynamic condition.
				$condition = $this->getCondition ( $emailTemplateVo );
				if (! AppUtil::isEmptyString ( $condition )) {
					$query .= " where " . $condition;
				}
			}
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, emailTemplateVo::class );
		} catch ( \Exception $e ) {
		}
	}
}