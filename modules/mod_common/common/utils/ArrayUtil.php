<?php
namespace common\utils;

class ArrayUtil{
	/**
	 * Sorting key of $objList by id field of $obj
	 * 
	 * @param array $objList
	 * @return array sorted
	 */
	public static function sortById($objList){
		$ret = array();
		foreach ($objList as $v){
			if(isset($v->id)){
				$ret[$v->id] = $v;
			}
		}
		return $ret;
	}
	
	/**
	 * convert array (of object) to array (of array)
	 * 
	 * @param array $arr
	 */
	public static function objectToArray($arr){
		if (is_array($arr) || is_object($arr))
		{
			$result = array();
			foreach ($arr as $k => $v){
				$result[$k] = self::objectToArray($v);
			}
			return $result;
		}
		return $arr;
	}
	
	/**
	 * recursive array $arr
	 * 
	 * @param array $arr (require field parentId and id)
	 * @param int $parentId
	 * @param array rel $ret
	 * @return data after recursived
	 */
	public static function recursive($arr, $parentId, $ret, $level=-1){
		foreach($arr as $k => $v){
			if($v['parentId'] == $parentId){
				$level++;
				$v['level'] = $level;
				$ret[] = $v;
				$ret = self::recursive($arr, $v['id'], $ret, $level);
				$level--;
			}
		}
		return $ret;
	}
	
	/**
	 * reset key of array
	 * 
	 * @param array $arr
	 */
	public static function resetKey($arr){
		$ret = array();
		foreach ($arr as $v){
			$ret[] = $v;
		}
		return $ret;
	}
}