<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\EmailTemplateLangVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class EmailTemplateLangMapping {
	final public function selectByKey(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "select * from `email_template_lang` where (`email_template_id` = #{emailTemplateId}) and (`language_code` = #{languageCode}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(EmailTemplateLangVo $emailTemplateLangVo = null) {
		try {
			$query = "select * from `email_template_lang`";
			$queryBuilder = new QueryBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "select * from `email_template_lang`";
			$queryBuilder = new QueryBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendCondition ( "`email_template_id`", "emailTemplateId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`from`", "from")
				->appendCondition ( "`reply`", "reply")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(EmailTemplateLangVo $emailTemplateLangVo = null) {
		try {
			$query = "select count(*) from `email_template_lang`";
			$queryBuilder = new QueryBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendCondition ( "`email_template_id`", "emailTemplateId")
				->appendCondition ( "`language_code`", "languageCode")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`from`", "from")
				->appendCondition ( "`reply`", "reply")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "insert into `email_template_lang`";
			$queryBuilder = new InsertBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendField("`email_template_id`", "emailTemplateId")
				->appendField("`language_code`", "languageCode")
				->appendField("`title`", "title")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`email_template_lang`", $queryBuilder->getSql (), EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "insert into `email_template_lang`";
			$queryBuilder = new InsertBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendField("`email_template_id`", "emailTemplateId")
				->appendField("`language_code`", "languageCode")
				->appendField("`title`", "title")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`email_template_lang`", $queryBuilder->getSql (), EmailTemplateLangVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "update `email_template_lang`";
			$queryBuilder = new UpdateBuilder ( $emailTemplateLangVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`email_template_lang`", $queryBuilder->getSql (), EmailTemplateLangVo::class, "where (`email_template_id` = #{emailTemplateId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(EmailTemplateLangVo $emailTemplateLangVo) {
		try {
			$query = "delete from `email_template_lang`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`email_template_lang`", $query, EmailTemplateLangVo::class, "where (`email_template_id` = #{emailTemplateId}) and (`language_code` = #{languageCode})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}