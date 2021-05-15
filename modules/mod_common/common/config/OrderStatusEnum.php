<?php
namespace common\config;
abstract class OrderStatusEnum extends BaseEnum {
	const PENDING = '1';
	const PAID = '2';
	const CANCELLED = '3';
	const REFUNDED = '4';
	const UNSUCESSFUL = '5';
}