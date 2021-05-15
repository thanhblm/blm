<?php
/**
 * Created by PhpStorm.
 * User: hungnt
 * Date: 5/4/2017
 * Time: 3:42 PM
 */

namespace backend\workflow\erdt;


use common\config\Attributes;
use common\config\ErrorCodes;
use common\services\erdt\ErdtService;
use common\utils\FileUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use common\persistence\extend\vo\OrderExtendVo;

class GenerateErdtCsvFileTask implements Task {

	public function execute(ContextBase &$context){
		try {
			$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::SUCCESS);
			$erdtSv = new ErdtService();
			$totalOrders = $erdtSv->getCountNonShippedOrders();
			if (empty($totalOrders) && 0 == $totalOrders) {
				\DatoLogUtil::info("There's no orders to ship.");
				return false;
			}

			$mapping = array(
				'order_number' => 'id',
				'customer_number' => 'customerId',
				'document_date' => 'orderDate',

				// Billing
				'billing_company' => 'customerCompany',
				'billing_name' => 'shipName',
				'billing_address_0' => '',
				'billing_address_1' => '',
				'billing_street' => 'billAddress',
				'billing_zip' => 'billZipcode',
				'billing_city' => 'billCity',
				'billing_country_iso' => 'billCountryCode',
				'billing_country_iso2' => 'billCountryCode',
				'billing_country' => 'billCountryName',
				'billing_email' => 'billEmail',
				'billing_phone' => 'billPhone',
				'billing_fax' => '',

				// Shipping
				'shipping_company' => 'customerCompany',
				'shipping_name' => 'shipName',
				'shipping_address_0' => '',
				'shipping_address_1' => '',
				'shipping_street' => 'shipAddress',
				'shipping_zip' => 'shipZipcode',
				'shipping_city' => 'shipCity',
				'shipping_country_iso' => 'shipCountryCode',
				'shipping_country_iso2' => 'shipCountryCode',
				'shipping_country' => 'shipCountryName',
				'shipping_email' => 'shipEmail',

				// Tax number, EU standard nr, order currency (USD etc.)
				'tax_number' => '',
				'euu_stld_nr' => '',
				'currency' => 'currencyCode',

				// Order carrier, payment condition (payed of course), order type
				'freight_carrier' => '',
				'payment_condition' => '',
				'order_type' => '',

				// Item information
				'item_number' => 'productId',
				'quantity' => 'productQuantity',
				'unit_price' => 'basePrice',

				// Sum order price, discount, tax code
				'sum_price' => '',
				'discount' => '',
				'tax_code' => '',

				// COD, client number
				'cod' => '',
				'client_number' => '',
			);
			$fileName = "ORDERS_" . date("Ymd_his");
			$orderIds = array();
			$orderExtendVo = new OrderExtendVo();
			$orderExtendVo->order_by = " id asc ";
			$filePath = FileUtil::exportCsvCustom($fileName, false, $mapping, $orderExtendVo, $erdtSv, "getNonShippedOrders", ";", "id", $orderIds);

			$context->set(Attributes::LIST_ORDER_IDS, $orderIds);
			$context->set(Attributes::FILE_NAME, $fileName);
			$context->set(Attributes::FILE_PATH, $filePath);
		} catch (Exception $e) {
			$context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
			$context->set(Attributes::ATTR_ERROR_MESSAGE, $e->getMessage());
			return false;
		}
	}
}