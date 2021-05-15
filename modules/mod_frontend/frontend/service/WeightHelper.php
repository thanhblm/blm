<?php

namespace frontend\service;

class WeightHelper {
	static $lb2mg = 453592;
	static $mg2lb = 0.000002205;
	public static function getMG2LB($weight) {
		$weight = $weight * self::$mg2lb;
		return $weight;
	}
	public static function getLB2MG($weight, $unit) {
		$weight = $weight * self::$lb2mg;
		return $weight;
	}
}