<?php

namespace common\config;

abstract class CommonStatusEnum extends BaseEnum {
	const PENDING = '1';
	const SUCCESS = '2';
	const FAILED = '3';
}