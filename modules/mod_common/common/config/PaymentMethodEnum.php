<?php
namespace common\config;
abstract class PaymentMethodEnum extends BaseEnum {
	const BANK_TRANSTER = '1';
	const AUTHORIZE_NET = '2';
	const CARDGATE = '3';
	const NETWORK_MERCHANTS = '4';
	const EPAY = '5';
}