<?php

namespace common\persistence\extend\mapping;

use common\persistence\base\vo\ContainerVo;
use common\persistence\base\vo\GridVo;
use core\database\SqlStatementInfo;
use core\database\QueryBuilder;

class ContainerExtendMapping {
	public function getGridListOfContainer(ContainerVo $containerVo) {
		try {
			$query = "select g.*
				from `grid` as g
				left join container as c on c.id = g.container_id
				where c.id = #{id}
				order by g.`order` asc, g.`id` asc";
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $query, GridVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	public function getContainerByPageId($pageId){
        try {
            if (!empty($pageId)){
                $query = "select * from `container` where page_id = $pageId";
                return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, ContainerVo::class);
            }else{
                return null;
            }
        } catch ( \Exception $e ) {
            throw $e;
        }
    }

	public function deleteByFilter(ContainerVo $filter) {
		try {
			if (!empty($filter->pageId)){
				$query = "delete from `container`";
				$queryBuilder = new QueryBuilder( $filter, "" );
				$queryBuilder
					->appendCondition ( "`page_id`", "pageId");
				return new SqlStatementInfo ( SqlStatementInfo::DELETE, null, $query, ContainerVo::class, $queryBuilder->getSql() );
			}
		} catch ( \Exception $e ) {
			throw $e;
		}
	}

	/**
	 * ***************************
	 * ADVANCE
	 * ***************************
	 */

	/**
	 * ***************************
	 * FILTER
	 * ***************************
	 */
	public function getCountByFilter(ContainerVo $containerVo = null) {
		try {
			$query = "select count(*) from `container`";
			$queryBuilder = new QueryBuilder( $containerVo, $query );
			$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "`position`", "position");
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
	public function getContainerByFilter(ContainerVo $containerVo) {
		try {
			$query = "select * from `container`";
			$queryBuilder = new QueryBuilder( $containerVo, $query );
			$queryBuilder
			->appendCondition ( "`id`", "id")
			->appendCondition ( "`name`", "name", "like", false, ":PARAM_BOTH_LIKE")
			->appendCondition ( "`position`", "position")
			->appendOrder()
			->appendLimit();
			return new SqlStatementInfo ( SqlStatementInfo::SELECT, null, $queryBuilder->getSql(), ContainerVo::class );
		} catch ( \Exception $e ) {
			throw $e;
		}
	}
}