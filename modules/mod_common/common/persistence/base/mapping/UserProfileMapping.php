<?php

namespace common\persistence\base\mapping;

use common\persistence\base\vo\UserProfileVo;
use core\database\InsertBuilder;
use core\database\QueryBuilder;
use core\database\SqlStatementInfo;
use core\database\UpdateBuilder;

class UserProfileMapping {
	final public function selectByKey(UserProfileVo $userProfileVo) {
		try {
			$query = "select * from `user_profile` where (`user_id` = #{userId}) limit 1";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectAll(UserProfileVo $userProfileVo = null) {
		try {
			$query = "select * from `user_profile`";
			$queryBuilder = new QueryBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function selectByFilter(UserProfileVo $userProfileVo) {
		try {
			$query = "select * from `user_profile`";
			$queryBuilder = new QueryBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`credit_card_number`", "creditCardNumber")
				->appendCondition ( "`cvv`", "cvv")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function countByFilter(UserProfileVo $userProfileVo = null) {
		try {
			$query = "select count(*) from `user_profile`";
			$queryBuilder = new QueryBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendCondition ( "`user_id`", "userId")
				->appendCondition ( "`credit_card_number`", "creditCardNumber")
				->appendCondition ( "`cvv`", "cvv");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql (), UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamic(UserProfileVo $userProfileVo) {
		try {
			$query = "insert into `user_profile`";
			$queryBuilder = new InsertBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendField("`user_id`", "userId")
				->appendField("`credit_card_number`", "creditCardNumber")
				->appendField("`cvv`", "cvv");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_profile`", $queryBuilder->getSql (), UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function insertDynamicWithId(UserProfileVo $userProfileVo) {
		try {
			$query = "insert into `user_profile`";
			$queryBuilder = new InsertBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendField("`user_id`", "userId")
				->appendField("`credit_card_number`", "creditCardNumber")
				->appendField("`cvv`", "cvv");
			return new SqlStatementInfo ( SqlStatementInfo::INSERT, "`user_profile`", $queryBuilder->getSql (), UserProfileVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function updateDynamicByKey(UserProfileVo $userProfileVo) {
		try {
			$query = "update `user_profile`";
			$queryBuilder = new UpdateBuilder ( $userProfileVo, $query );
			$queryBuilder
				->appendField("`credit_card_number`", "creditCardNumber")
				->appendField("`cvv`", "cvv");
			return new SqlStatementInfo ( SqlStatementInfo::UPDATE, "`user_profile`", $queryBuilder->getSql (), UserProfileVo::class, "where (`user_id` = #{userId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	final public function deleteByKey(UserProfileVo $userProfileVo) {
		try {
			$query = "delete from `user_profile`";
			return new SqlStatementInfo ( SqlStatementInfo::DELETE, "`user_profile`", $query, UserProfileVo::class, "where (`user_id` = #{userId})" );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}