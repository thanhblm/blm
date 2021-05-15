<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\mapping\AddressMapping;
use common\persistence\extend\vo\AddressExtendVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class AddressExtendMapping extends AddressMapping {
	public function search(AddressExtendVo $addressExtendVo) {
		try {
			$query = "
				select 
					a.*, 
					c.`name` country_name, 
					s.`name` state_name 
				from address a
				left join country c on c.`id` = a.country
				left join state s on s.`id` = a.state";
			$queryBuilder = new QueryBuilder($addressExtendVo, $query );
			$queryBuilder
				->appendCondition ( "a.`id`", "id")
				->appendCondition ( "a.`first_name`", "firstName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`last_name`", "lastName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`email`", "email", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`group_id`", "groupId")
				->appendCondition ( "a.`type`", "type")
				->appendOrder()
				->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), AddressExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function searchCount(AddressExtendVo $addressExtendVo) {
		try {
			$query = "
				select 
					count(*)
				from address a
				left join country c on c.`id` = a.country
				left join state s on s.`id` = a.state";
			$queryBuilder = new QueryBuilder($addressExtendVo, $query );
			$queryBuilder
				->appendCondition ( "a.`id`", "id")
				->appendCondition ( "a.`first_name`", "firstName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`last_name`", "lastName", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`email`", "email", "like", false,":PARAM_BOTH_LIKE")
				->appendCondition ( "a.`group_id`", "groupId")
				->appendCondition ( "a.`type`", "type");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), AddressExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}