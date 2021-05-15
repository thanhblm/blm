<?php

namespace common\config;

abstract class LogTypeEnum extends BaseEnum {
	const CARDGATE = 'cardgate';
	const AUTHORIZENET = 'authorizenet';
	const SHIPRUSH = 'shiprush';
	const EPAY = 'epay';
}