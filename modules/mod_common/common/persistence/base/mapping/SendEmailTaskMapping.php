<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\SendEmailTaskVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class SendEmailTaskMapping {
	final public function selectByKey(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "select * from `send_email_task` where (`id` = #{id}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(SendEmailTaskVo $sendEmailTaskVo = null) {
		try {
			$query = "select * from `send_email_task`";
			$queryBuilder = new QueryBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "select * from `send_email_task`";
			$queryBuilder = new QueryBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`from_name`", "fromName")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`to`", "to")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc")
				->appendCondition ( "`attachments`", "attachments")
				->appendCondition ( "`status`", "status")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(SendEmailTaskVo $sendEmailTaskVo = null) {
		try {
			$query = "select count(*) from `send_email_task`";
			$queryBuilder = new QueryBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendCondition ( "`id`", "id")
				->appendCondition ( "`from_name`", "fromName")
				->appendCondition ( "`subject`", "subject")
				->appendCondition ( "`body`", "body")
				->appendCondition ( "`to`", "to")
				->appendCondition ( "`cc`", "cc")
				->appendCondition ( "`bcc`", "bcc")
				->appendCondition ( "`attachments`", "attachments")
				->appendCondition ( "`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "insert into `send_email_task`";
			$queryBuilder = new InsertBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendField("`from_name`", "fromName")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`to`", "to")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`attachments`", "attachments")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`send_email_task`", $queryBuilder->getSql (), SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "insert into `send_email_task`";
			$queryBuilder = new InsertBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendField("`id`", "id")
				->appendField("`from_name`", "fromName")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`to`", "to")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`attachments`", "attachments")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`send_email_task`", $queryBuilder->getSql (), SendEmailTaskVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "update `send_email_task`";
			$queryBuilder = new UpdateBuilder ( $sendEmailTaskVo, $query );
			$queryBuilder
				->appendField("`from_name`", "fromName")
				->appendField("`subject`", "subject")
				->appendField("`body`", "body")
				->appendField("`to`", "to")
				->appendField("`cc`", "cc")
				->appendField("`bcc`", "bcc")
				->appendField("`attachments`", "attachments")
				->appendField("`status`", "status");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`send_email_task`", $queryBuilder->getSql (), SendEmailTaskVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(SendEmailTaskVo $sendEmailTaskVo) {
		try {
			$query = "delete from `send_email_task`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`send_email_task`", $query, SendEmailTaskVo::class, "where (`id` = #{id})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}