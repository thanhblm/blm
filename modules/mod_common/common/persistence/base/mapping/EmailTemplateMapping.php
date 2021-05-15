<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\EmailTemplateVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class EmailTemplateMapping {
	final public function selectByKey(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "select * from `email_template` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(EmailTemplateVo $emailTemplateVo = null) {
		try {
			$query = "select * from `email_template`";
			$queryBuilder = new QueryBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "select * from `email_template`";
			$queryBuilder = new QueryBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`send_to`", "sendTo")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`from`", "from")
				->appendCondition ( "`to`", "to")
				->appendCondition ( "`reply`", "reply")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc")
				->appendCondition ( "`tags`", "tags")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(EmailTemplateVo $emailTemplateVo = null) {
		try {
			$query = "select count(*) from `email_template`";
			$queryBuilder = new QueryBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`title`", "title")
				->appendCondition ( "`send_to`", "sendTo")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`from`", "from")
				->appendCondition ( "`to`", "to")
				->appendCondition ( "`reply`", "reply")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc")
				->appendCondition ( "`tags`", "tags")
				->appendCondition ( "`cr_date`", "crDate")
				->appendCondition ( "`cr_by`", "crBy")
				->appendCondition ( "`md_date`", "mdDate")
				->appendCondition ( "`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "insert into `email_template`";
			$queryBuilder = new InsertBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`send_to`", "sendTo")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`to`", "to")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`tags`", "tags")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`email_template`", $queryBuilder->getSql (), EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "insert into `email_template`";
			$queryBuilder = new InsertBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`title`", "title")
				->appendField("`send_to`", "sendTo")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`to`", "to")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`tags`", "tags")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`email_template`", $queryBuilder->getSql (), EmailTemplateVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "update `email_template`";
			$queryBuilder = new UpdateBuilder ( $emailTemplateVo, $query );
			$queryBuilder
				->appendField("`title`", "title")
				->appendField("`send_to`", "sendTo")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`from`", "from")
				->appendField("`to`", "to")
				->appendField("`reply`", "reply")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`tags`", "tags")
				->appendField("`cr_date`", "crDate")
				->appendField("`cr_by`", "crBy")
				->appendField("`md_date`", "mdDate")
				->appendField("`md_by`", "mdBy");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`email_template`", $queryBuilder->getSql (), EmailTemplateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(EmailTemplateVo $emailTemplateVo) {
		try {
			$query = "delete from `email_template`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`email_template`", $query, EmailTemplateVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}