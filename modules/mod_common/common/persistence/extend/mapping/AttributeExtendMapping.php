<?php

namespace common\persistence\extend\mapping;

use common\filter\attribute_group\AttributeFilter;
use common\persistence\base\mapping\AttributeMapping;
use common\persistence\base\vo\AttributeVo;
use common\persistence\extend\vo\AttributeExtendVo;
use common\utils\StringUtil;
use core\database\SqlStatementInfo;
use core\utils\AppUtil;

class AttributeExtendMapping extends AttributeMapping{

	public function search(AttributeFilter $filter) {
		try {
			$query ="select
						attr.*,
						c.`name` category_name,
						atg.`name` attr_group_name
					from attribute attr
					left join category c on c.`id` = attr.category_id
					left join attr_group atg on atg.`id` = attr.attr_group_id"
						. $this->buildCondition($filter)
						. $this->buildPaging($filter);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttributeExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	public function searchCount(AttributeFilter $filter) {
		try {
			$query ="select
						count(*)
					from attribute attr
					left join category c on c.`id` = attr.category_id
					left join attr_group atg on atg.`id` = attr.attr_group_id"
						. $this->buildCondition($filter);
						return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttributeExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	public function searchByKey(AttributeFilter $filter) {
		try {
			$query ="select
						attr.*,
						c.`name` category_name,
						atg.`name` attr_group_name
					from attribute attr
					left join category c on c.`id` = attr.category_id
					left join attr_group atg on atg.`id` = attr.attr_group_id"
					. $this->buildCondition($filter);
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttributeExtendVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	public function searchByIds($listId) {
		try {
			$stringIn = "('')";
			if(count($listId) > 0){
				$stringIn = StringUtil::convertArrayToStringForSelectIn($listId);
			}
			$query ="select
						attr.*
					from attribute attr
					left join attr_group atg on atg.`id` = attr.attr_group_id
					where attr.id in" . $stringIn;

			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, AttributeVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	private function buildPaging($filter){
		$endQuery = "";
		$objInfo = get_object_vars($filter);

		if(!AppUtil::isEmptyString($objInfo['order_by'])){
			$endQuery = $endQuery . " order by attr.".$objInfo['order_by'];
		}
		if(!AppUtil::isEmptyString($objInfo['start_record'])){
			if(!AppUtil::isEmptyString($objInfo['end_record'])){
				$endQuery = $endQuery . " LIMIT  #{start_record:PARAM_INT},#{end_record:PARAM_INT}";
			}else{
				$endQuery = $endQuery . " LIMIT #{start_record:PARAM_INT}";
			}
		}
		return  $endQuery;
	}

	private function buildCondition($filter){
		$condition = " where 1=1 ";
		$objInfo = get_object_vars($filter);
		if(!AppUtil::isEmptyString($objInfo['categoryId'])){
			$condition .= " AND attr.category_id = #{categoryId}";
		}
		if(!AppUtil::isEmptyString($objInfo['attrGroupId'])){
			$condition .= " AND attr.attr_group_id = #{attrGroupId}";
		}
		if(!AppUtil::isEmptyString($objInfo['name'])){
			$condition .= " AND attr.name LIKE #{name:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['description'])){
			$condition .= " AND attr.description LIKE #{description:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['order'])){
			$condition .= " AND attr.order = #{order}";
		}
		if(!AppUtil::isEmptyString($objInfo['code'])){
			$condition .= " AND attr.code = #{code}";
		}
		if(!AppUtil::isEmptyString($objInfo['categoryName'])){
			$condition .= " AND c.name LIKE #{categoryName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['attrGroupName'])){
			$condition .= " AND atg.name LIKE #{attrGroupName:PARAM_BOTH_LIKE}";
		}
		if(!AppUtil::isEmptyString($objInfo['id'])){
			$condition .= " AND attr.id = #{id}";
		}
		return $condition;
	}
}