<?php

namespace common\config;

abstract class ShippingStatusEnum extends BaseEnum {
	const NEW_SHIP = '1';
	const ORDERED = '2';
	const RESERVED = '3';
	const SENDING = '4';
	const FINISHED = '5';
}