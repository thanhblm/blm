<?php

namespace frontend\service;

use common\config\LogTypeEnum;
use common\config\ShippingStatusEnum;
use common\config\shiprush\ShiprushShipmentChgTypeEnum;
use common\config\shiprush\ShiprushShippingTypeEnum;
use common\helper\LogHelper;
use common\model\ResponseMo;
use common\model\ShiprushMo;
use common\model\ShiprushOrderItemMo;
use common\persistence\base\vo\OrderChargeInfoVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\base\vo\OrderVo;
use common\utils\DateUtil;
use core\utils\AppUtil;
use core\utils\EncryptUtil;
use core\utils\RequestUtil;
use common\helper\SettingHelper;

class ShipRushHelper {
	
	// live
	// private static $upsAccNo = '04346X'; // secondary
	private static $upsAccNo = '4E15W9';
	private static $shiprushURL = 'https://api.my.shiprush.com/IntegrationService.svc/WSGTBmZf7EelJqcFAUV8gQ/cvRvRdybkk-ILKYtAEICag/order/add';
	private static $secretToken = 'AqNYvCaRfjFN4eSa';
	private static $isSandbox = false;
	// dev
	// private static $upsAccNo = '123555';
	// private static $shiprushURL = 'https://api.my.shiprush.com/IntegrationService.svc/IUQ1nuzMn06bl6dtACQSuA/cvRvRdybkk-ILKYtAEICag/order/add';
	// private static $secretToken = 'AqNYvCaRfjFN4eSa';
	// private static $isSandbox = true;
	// private static $isDebug = true;
	// private static $upsAccNo = null;
	// private static $shiprushURL = null;
	// private static $secretToken = null;
	// private static $isSandbox = null;
	private static $isDebug = null;
	private static $isInit = null;
	private static function init() {
		if (! self::$isInit) {
			if (SettingHelper::getSettingValue ( "Shiprush Enviroment" ) == 'live') {
				self::$upsAccNo = SettingHelper::getSettingValue ( "Shiprush UPS Acc No (live)" );
				self::$shiprushURL = SettingHelper::getSettingValue ( "Shiprush URL (live)" );
				self::$secretToken = SettingHelper::getSettingValue ( "Shiprush Token (live)" );
				self::$isSandbox = false;
			} else {
				self::$upsAccNo = SettingHelper::getSettingValue ( "Shiprush UPS Acc No (sandbox)" );
				self::$shiprushURL = SettingHelper::getSettingValue ( "Shiprush URL (sandbox)" );
				if (empty ( self::$shiprushURL )) {
					self::$shiprushURL = SettingHelper::getSettingValue ( "Shiprush Shiprush URL (sandbox)" );
				}
				self::$secretToken = SettingHelper::getSettingValue ( "Shiprush Token (sandbox)" );
				self::$isSandbox = true;
			}
			
			self::$isDebug = SettingHelper::getSettingValue ( "Shiprush Debug" ) == 'yes' ? true : false;
			self::$isInit = true;
		}
	}
	public static function sendShiprushOrder($orderId) {
		\DatoLogUtil::debug ( '+ sendShiprushOrder +' );
		self::init ();
		$responseVo = new ResponseMo ();
		$orderHistoryVo = new OrderHistoryVo ();
		$orderHistoryVo->orderId = $orderId;
		$orderShippingInfoVo = OrderHelper::getOrderShippingInfoVoByOrderId ( $orderId );
		if (empty ( $orderShippingInfoVo ))
			$orderShippingInfoVo = new OrderShipingInfoVo ();
		$isInsertShippingInfo = false;
		if (empty ( $orderShippingInfoVo->orderId )) {
			$orderShippingInfoVo->orderId = $orderId;
			$orderShippingInfoVo->shipBy = 'shiprush';
			$orderShippingInfoVo->shipDate = DateUtil::getCurrentDT ();
			$isInsertShippingInfo = true;
		}
		$xml = self::getXML ( $orderId );
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_URL, self::$shiprushURL );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-Type: text/xml; charset=utf-8' 
		) );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xml );
		// remove to prevent data sent to shiprush
		$res = curl_exec ( $ch );
		$err = curl_errno ( $ch );
		$info = curl_getinfo ( $ch );
		curl_close ( $ch );
		
		\DatoLogUtil::debug ( $res );
		\DatoLogUtil::debug ( $err );
		\DatoLogUtil::debug ( $info );
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::SHIPRUSH, self::$shiprushURL, $xml, $res );
		$msg = 'Order failed to be sent to ShipRush. ';
		$orderHistoryVo->status = ShippingStatusEnum::NEW_SHIP;
		$orderHistoryVo->description = $msg;
		ResponseHelper::setError ( $responseVo, $msg );
		if (! empty ( $res )) {
			$dom = new \DOMDocument ( '1.0' );
			$dom->preserveWhiteSpace = false;
			$dom->formatOutput = true;
			$dom->loadXML ( $res );
			$res = $dom->saveXML ();
			$xmlRes = new \SimpleXMLElement ( $res );
			$trackingCode = $xmlRes->OrderId;
			if (! empty ( $trackingCode )) {
				// update shipping info trackingcode
				$orderShippingInfoVo->trackingCode = $trackingCode;
				$msg = 'Order successfully shipped by Shiprush send order. trackingCode:' . $trackingCode;
				$orderHistoryVo->status = ShippingStatusEnum::FINISHED;
				$orderHistoryVo->description = $msg;
				OrderHelper::updateOrderShippingStatus ( $orderId, ShippingStatusEnum::FINISHED );
				ResponseHelper::setSuccess ( $responseVo, $msg );
			}
		}
		if ($err) {
			\DatoLogUtil::error ( $err );
			$msg = 'Order failed by Shiprush send order. Err:' . $err;
			$orderHistoryVo->status = ShippingStatusEnum::NEW_SHIP;
			$orderHistoryVo->description = $msg;
			ResponseHelper::setError ( $responseVo, $msg );
		}
		\DatoLogUtil::trace ( $orderHistoryVo );
		OrderHelper::insertUpdateOrderShippingInfo ( $orderShippingInfoVo, $isInsertShippingInfo );
		OrderHelper::insertShippingOrderHistory ( $orderHistoryVo );
		
		\DatoLogUtil::debug ( '- sendShiprushOrder -' );
		return $responseVo;
	}
	public static function testSend() {
		self::init ();
		$xml = self::getSampleXML ();
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt ( $ch, CURLOPT_TIMEOUT, 180 );
		curl_setopt ( $ch, CURLOPT_URL, self::$shiprushURL );
		curl_setopt ( $ch, CURLOPT_POST, 1 );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, array (
				'Content-Type: text/xml; charset=utf-8' 
		) );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $xml );
		// remove to prevent data sent to shiprush
		$res = curl_exec ( $ch );
		$err = curl_errno ( $ch );
		$info = curl_getinfo ( $ch );
		curl_close ( $ch );
		if (self::$isDebug)
			LogHelper::logRequest ( LogTypeEnum::SHIPRUSH, self::$shiprushURL, $xml, $res );
		\DatoLogUtil::debug ( $res );
		\DatoLogUtil::debug ( $err );
		\DatoLogUtil::debug ( $info );
	}
	public static function getShiprushMoByOrderId($orderId) {
		self::init ();
		$shiprushMo = new ShiprushMo ();
		
		$orderVo = OrderHelper::getOrderVoById ( $orderId );
		$orderProductVoList = OrderHelper::getOrderProductVoListByOrderId ( $orderId );
		$orderChargeInfoVo = OrderHelper::getOrderChargeInfoVoByOrderId ( $orderId );
		$orderShippingInfoVo = OrderHelper::getOrderShippingInfoVoByOrderId ( $orderId );
		$callbackURL = AppUtil::web_url ( "home/cart/shipping/shiprush/callback" );
		// \DatoLogUtil::trace ( $orderVo );
		// \DatoLogUtil::trace ( $orderProductVoList );
		// \DatoLogUtil::trace ( $orderChargeInfoVo );
		// \DatoLogUtil::trace ( $orderShippingInfoVo );
		$shiprushMo->upsAccountNumber = self::$upsAccNo;
		$shiprushMo->shipmentType = ShiprushShippingTypeEnum::PENDING;
		$shiprushMo->postBackURL = $callbackURL . '?enId=' . EncryptUtil::encryptString ( $orderId, self::$secretToken );
		$shiprushMo->upsServiceType = self::getUPSServiceTypeByShippingMethod ( $orderVo->shippingMethodItem );
		$shiprushMo->shipmentChgType = ShiprushShipmentChgTypeEnum::PRE;
		$shiprushMo->shipNotificationEmail = $orderVo->shipEmail;
		$shiprushMo->uomWeight = 'LBS';
		$shiprushMo->unitsOfMeasureLinear = 'IN';
		$shiprushMo->packagingType = '02';
		if (self::$isSandbox)
			$shiprushMo->packageReference1 = 'Test #' . $orderId;
		else
			$shiprushMo->packageReference1 = 'Order #' . $orderId;
		$shiprushMo->shipFirstName = $orderVo->shipFirstName;
		$shiprushMo->shipLastName = $orderVo->shipLastName;
		$shiprushMo->shipAddress1 = $orderVo->shipAddress;
		$shiprushMo->shipCity = $orderVo->shipCity;
		$shiprushMo->shipState = $orderVo->shipStateCode;
		$shiprushMo->shipStateAsString = GeoHelper::getStateNameByStateCode ( $orderVo->shipStateCode, $orderVo->shipCountryCode );
		$shiprushMo->shipCountry = $orderVo->shipCountryCode;
		$shiprushMo->shipCountryAsString = GeoHelper::getCountryNameByCountryCode ( $orderVo->shipCountryCode );
		$shiprushMo->shipPostalCode = $orderVo->shipZipcode;
		$shiprushMo->shipPhone = $orderVo->shipPhone;
		
		$shiprushMo->storeCompany = 'Endoca USA';
		$shiprushMo->storeName = 'Endoca USA 619-831-0156';
		$shiprushMo->storeAddress1 = '2305 Historic Decatur Rd Suite 100';
		$shiprushMo->storeCity = 'San Diego';
		$shiprushMo->storeState = 'CA';
		$shiprushMo->storeCountry = 'US';
		$shiprushMo->storePostalCode = '92106';
		$shiprushMo->storePhone = '5098089727';
		
		$shiprushMo->unitsOfMeasureWeight = 'LBS';
		$shiprushMo->unitsOfMeasureLinear = 'IN';
		
		$itemWeightTotal = 0;
		foreach ( $orderProductVoList as $orderProductVo ) {
			// \DatoLogUtil::trace ( $orderProductVo );
			$shiprushOrderItemMo = new ShiprushOrderItemMo ();
			$shiprushOrderItemMo->externalId = $orderProductVo->productId;
			$shiprushOrderItemMo->name = $orderProductVo->name;
			$shiprushOrderItemMo->price = CurrencyHelper::getDoubleFormat ( $orderProductVo->price );
			$shiprushOrderItemMo->quantity = $orderProductVo->quantity;
			$shiprushOrderItemMo->total = CurrencyHelper::getDoubleFormat ( $orderProductVo->price * $orderProductVo->quantity );
			$shiprushMo->orderItemList [] = $shiprushOrderItemMo;
			$prodcutVo = OrderHelper::getProductVoByProductId ( $orderProductVo->productId );
			if (strtolower ( $prodcutVo->weightUnit ) == 'mg')
				$prodcutVo->weight = WeightHelper::getMG2LB ( $prodcutVo->weight );
			$itemWeightTotal += $orderProductVo->quantity * $prodcutVo->weight;
		}
		$shiprushMo->packageActualWeight = $itemWeightTotal;
		$shiprushMo->paymentStatus = 2; // 0 1 2
		$shiprushMo->shippingChargesPaid = CurrencyHelper::getDoubleFormat ( $orderChargeInfoVo->shippingAmount );
		$shiprushMo->orderShipMethod = $orderVo->shippingMethod; // Flat_0, Flat_1, Flat_2, Flat_3, Free_free
		$shiprushMo->orderDate = $orderVo->crDate;
		$shiprushMo->orderItemsTotal = CurrencyHelper::getDoubleFormat ( $orderChargeInfoVo->subTotalAmount );
		$shiprushMo->orderTotalAmt = CurrencyHelper::getDoubleFormat ( $orderChargeInfoVo->grandTotalAmount );
		$shiprushMo->orderItemsTax = CurrencyHelper::getDoubleFormat ( $orderChargeInfoVo->taxAmount );
		$orderNumber = $orderVo->id;
		if (self::$isSandbox) {
			$orderNumber = 'TEST' . $orderVo->id;
		}
		$shiprushMo->orderNumber = $orderNumber;
		$shiprushMo->orderExternalID = $orderNumber;
		
		$shiprushMo->billFirstName = $orderVo->billFirstName;
		$shiprushMo->billLastName = $orderVo->billLastName;
		// $shiprushMo->billCompany = $orderVo->bill;
		$shiprushMo->billAddress1 = $orderVo->billAddress;
		$shiprushMo->billCity = $orderVo->billCity;
		$shiprushMo->billState = $orderVo->billStateCode;
		$shiprushMo->billStateAsString = GeoHelper::getStateNameByStateCode ( $orderVo->billStateCode, $orderVo->billCountryCode );
		$shiprushMo->billCountry = $orderVo->billCountryCode;
		$shiprushMo->billCountryAsString = GeoHelper::getCountryNameByCountryCode ( $orderVo->billCountryCode );
		$shiprushMo->billPostalCode = $orderVo->billZipcode;
		$shiprushMo->billPhone = $orderVo->billPhone;
		$shiprushMo->billEmail = $orderVo->billEmail;
		
		$shiprushMo->shipFirstName = $orderVo->shipFirstName;
		$shiprushMo->shipLastName = $orderVo->shipLastName;
		// $shiprushMo->shipCompany = $orderVo->shipc;
		$shiprushMo->shipAddress1 = $orderVo->shipAddress;
		$shiprushMo->shipCity = $orderVo->shipCity;
		$shiprushMo->shipState = $orderVo->shipStateCode;
		$shiprushMo->shipStateAsString = GeoHelper::getStateNameByStateCode ( $orderVo->shipStateCode, $orderVo->shipCountryCode );
		$shiprushMo->shipCountry = $orderVo->shipCountryCode;
		$shiprushMo->shipCountryAsString = GeoHelper::getCountryNameByCountryCode ( $orderVo->shipCountryCode );
		$shiprushMo->shipPostalCode = $orderVo->shipZipcode;
		$shiprushMo->shipPhone = $orderVo->shipPhone;
		$shiprushMo->shipEmail = $orderVo->shipEmail;
		
		return $shiprushMo;
	}
	public static function getXML($orderId) {
		$shiprushMo = new ShiprushMo ();
		$shiprushOrderItemMo = new ShiprushOrderItemMo ();
		$shiprushMo = self::getShiprushMoByOrderId ( $orderId );
		$xml = null;
		$xml .= '<?xml version="1.0" encoding="utf-8"?>';
		$xml .= '<Request xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">';
		$xml .= '<ShipTransaction>';
		$xml .= '<Shipment>';
		$xml .= '<ShipmentType>' . htmlspecialchars ( $shiprushMo->shipmentType ) . '</ShipmentType>';
		$xml .= '<PostbackUrl>' . htmlspecialchars ( $shiprushMo->postBackURL ) . '</PostbackUrl>';
		$xml .= '<UPSServiceType>' . htmlspecialchars ( $shiprushMo->upsServiceType ) . '</UPSServiceType>';
		$xml .= '<ShipmentChgType>' . htmlspecialchars ( $shiprushMo->shipmentChgType ) . '</ShipmentChgType>';
		$xml .= '<ShipNotificationEmail>' . htmlspecialchars ( $shiprushMo->shipNotificationEmail ) . '</ShipNotificationEmail>';
		$xml .= '<UOMWeight>' . $shiprushMo->uomWeight . '</UOMWeight>';
		$xml .= '<UnitsOfMeasureLinear>' . htmlspecialchars ( $shiprushMo->unitsOfMeasureLinear ) . '</UnitsOfMeasureLinear>';
		$xml .= '<Package>';
		$xml .= '<PackageActualWeight>' . ( float ) $shiprushMo->packageActualWeight . '</PackageActualWeight>';
		$xml .= '<PackagingType>' . htmlspecialchars ( $shiprushMo->packagingType ) . '</PackagingType>';
		$xml .= '<PackageReference1>' . htmlspecialchars ( $shiprushMo->packageReference1 ) . '</PackageReference1>';
		$xml .= '</Package>';
		$xml .= '<DeliveryAddress>';
		$xml .= '<Address>';
		$xml .= '<FirstName>' . htmlspecialchars ( $shiprushMo->shipFirstName ) . '</FirstName>';
		$xml .= '<LastName>' . htmlspecialchars ( $shiprushMo->shipLastName ) . '</LastName>';
		$xml .= '<Address1>' . htmlspecialchars ( $shiprushMo->shipAddress1 ) . '</Address1>';
		$xml .= '<City>' . htmlspecialchars ( $shiprushMo->shipCity ) . '</City>';
		if ($shiprushMo->shipCountry == 'US') {
			$xml .= '<State>' . htmlspecialchars ( $shiprushMo->shipState ) . '</State>';
			$xml .= '<StateAsString>' . htmlspecialchars ( $shiprushMo->shipStateAsString ) . '</StateAsString>';
		}
		$xml .= '<Country>' . htmlspecialchars ( $shiprushMo->shipCountry ) . '</Country>';
		$xml .= '<CountryAsString>' . htmlspecialchars ( $shiprushMo->shipCountryAsString ) . '</CountryAsString>';
		$xml .= '<PostalCode>' . htmlspecialchars ( $shiprushMo->shipPostalCode ) . '</PostalCode>';
		$xml .= '<Phone>' . htmlspecialchars ( $shiprushMo->shipPhone ) . '</Phone>';
		$xml .= '</Address>';
		$xml .= '</DeliveryAddress>';
		$xml .= '<ShipperAddress>';
		$xml .= '<UPSAccountNumber>' . htmlspecialchars ( $shiprushMo->upsAccountNumber ) . '</UPSAccountNumber>';
		$xml .= '<Address>';
		$xml .= '<Company>' . htmlspecialchars ( $shiprushMo->storeCompany ) . '</Company>';
		$xml .= '<Name>' . htmlspecialchars ( $shiprushMo->storeName ) . '</Name>';
		$xml .= '<Address1>' . htmlspecialchars ( $shiprushMo->storeAddress1 ) . '</Address1>';
		$xml .= '<City>' . htmlspecialchars ( $shiprushMo->storeCity ) . '</City>';
		$xml .= '<State>' . htmlspecialchars ( $shiprushMo->storeState ) . '</State>';
		$xml .= '<Country>' . htmlspecialchars ( $shiprushMo->storeCountry ) . '</Country>';
		$xml .= '<PostalCode>' . htmlspecialchars ( $shiprushMo->storePostalCode ) . '</PostalCode>';
		$xml .= '<Phone>' . htmlspecialchars ( $shiprushMo->storePhone ) . '</Phone>';
		$xml .= '</Address>';
		$xml .= '</ShipperAddress>';
		$xml .= '</Shipment>';
		$xml .= '<Order>';
		$xml .= '<UnitsOfMeasureWeight>' . htmlspecialchars ( $shiprushMo->unitsOfMeasureWeight ) . '</UnitsOfMeasureWeight>';
		$xml .= '<UnitsOfMeasureLinear>' . htmlspecialchars ( $shiprushMo->unitsOfMeasureLinear ) . '</UnitsOfMeasureLinear>';
		if (count ( $shiprushMo->orderItemList ))
			foreach ( $shiprushMo->orderItemList as $shiprushOrderItemMo ) {
				$xml .= '<ShipmentOrderItem>';
				$xml .= '<Name>' . htmlspecialchars ( $shiprushOrderItemMo->name ) . '</Name>';
				$xml .= '<Price>' . htmlspecialchars ( $shiprushOrderItemMo->price ) . '</Price>';
				$xml .= '<ExternalID>' . htmlspecialchars ( $shiprushOrderItemMo->externalId ) . '</ExternalID>';
				$xml .= '<Quantity>' . htmlspecialchars ( $shiprushOrderItemMo->quantity ) . '</Quantity>';
				$xml .= '<Total>' . htmlspecialchars ( $shiprushOrderItemMo->total ) . '</Total>';
				$xml .= '</ShipmentOrderItem>';
			}
		$xml .= '<PackageActualWeight>' . ( float ) $shiprushMo->packageActualWeight . '</PackageActualWeight>';
		$xml .= '<PaymentStatus>' . htmlspecialchars ( $shiprushMo->paymentStatus ) . '</PaymentStatus>';
		$xml .= '<ShippingChargesPaid>' . htmlspecialchars ( $shiprushMo->shippingChargesPaid ) . '</ShippingChargesPaid>';
		$xml .= '<ShipMethod>' . htmlspecialchars ( $shiprushMo->orderShipMethod ) . '</ShipMethod>';
		$xml .= '<OrderDate>' . htmlspecialchars ( $shiprushMo->orderDate ) . '</OrderDate>';
		$xml .= '<ItemsTotal>' . htmlspecialchars ( $shiprushMo->orderItemsTotal ) . '</ItemsTotal>';
		$xml .= '<Total>' . htmlspecialchars ( $shiprushMo->orderTotalAmt ) . '</Total>';
		$xml .= '<ItemsTax>' . htmlspecialchars ( $shiprushMo->orderItemsTax ) . '</ItemsTax>';
		$xml .= '<OrderNumber>' . htmlspecialchars ( $shiprushMo->orderNumber ) . '</OrderNumber>';
		$xml .= '<ExternalID>' . htmlspecialchars ( $shiprushMo->orderExternalID ) . '</ExternalID>';
		$xml .= '<BillingAddress>';
		$xml .= '<FirstName>' . htmlspecialchars ( $shiprushMo->billFirstName ) . '</FirstName>';
		$xml .= '<LastName>' . htmlspecialchars ( $shiprushMo->billLastName ) . '</LastName>';
		$xml .= '<Company>' . htmlspecialchars ( $shiprushMo->billCompany ) . '</Company>';
		$xml .= '<Address1>' . htmlspecialchars ( $shiprushMo->billAddress1 ) . '</Address1>';
		$xml .= '<City>' . htmlspecialchars ( $shiprushMo->billCity ) . '</City>';
		$xml .= '<State>' . htmlspecialchars ( $shiprushMo->billState ) . '</State>';
		$xml .= '<StateAsString>' . htmlspecialchars ( $shiprushMo->billStateAsString ) . '</StateAsString>';
		$xml .= '<Country>' . htmlspecialchars ( $shiprushMo->billCountry ) . '</Country>';
		$xml .= '<CountryAsString>' . htmlspecialchars ( $shiprushMo->billCountryAsString ) . '</CountryAsString>';
		$xml .= '<PostalCode>' . htmlspecialchars ( $shiprushMo->billPostalCode ) . '</PostalCode>';
		$xml .= '<Phone>' . htmlspecialchars ( $shiprushMo->billPhone ) . '</Phone>';
		$xml .= '<EMail>' . htmlspecialchars ( $shiprushMo->billEmail ) . '</EMail>';
		$xml .= '</BillingAddress>';
		$xml .= '<ShippingAddress>';
		$xml .= '<FirstName>' . htmlspecialchars ( $shiprushMo->shipFirstName ) . '</FirstName>';
		$xml .= '<LastName>' . htmlspecialchars ( $shiprushMo->shipLastName ) . '</LastName>';
		$xml .= '<Company>' . htmlspecialchars ( $shiprushMo->shipCompany ) . '</Company>';
		$xml .= '<Address1>' . htmlspecialchars ( $shiprushMo->shipAddress1 ) . '</Address1>';
		$xml .= '<City>' . htmlspecialchars ( $shiprushMo->shipCity ) . '</City>';
		$xml .= '<State>' . htmlspecialchars ( $shiprushMo->shipState ) . '</State>';
		$xml .= '<StateAsString>' . htmlspecialchars ( $shiprushMo->shipStateAsString ) . '</StateAsString>';
		$xml .= '<Country>' . htmlspecialchars ( $shiprushMo->shipCountry ) . '</Country>';
		$xml .= '<CountryAsString>' . htmlspecialchars ( $shiprushMo->shipCountryAsString ) . '</CountryAsString>';
		$xml .= '<PostalCode>' . htmlspecialchars ( $shiprushMo->shipPostalCode ) . '</PostalCode>';
		$xml .= '<Phone>' . htmlspecialchars ( $shiprushMo->shipPhone ) . '</Phone>';
		$xml .= '<EMail>' . htmlspecialchars ( $shiprushMo->shipEmail ) . '</EMail>';
		$xml .= '</ShippingAddress>';
		$xml .= '</Order>';
		$xml .= '</ShipTransaction>';
		$xml .= '</Request>';
		\DatoLogUtil::trace ( $xml );
		$dom = new \DOMDocument ( '1.0' );
		$dom->preserveWhiteSpace = false;
		$dom->formatOutput = true;
		$dom->loadXML ( $xml );
		$xml = $dom->saveXML ();
		return $xml;
	}
	public static function getSampleXML() {
		$xml = '<?xml version="1.0" encoding="utf-8"?>
 <Request xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema">
   <ShipTransaction>
     <Shipment>
       <ShipmentType>Pending</ShipmentType>
       <PostbackUrl>https://www.endoca.com/src/731222-hshRJbLi4n</PostbackUrl>
       <ShipmentChgType>PRE</ShipmentChgType>
       <ShipNotificationEmail>zinomalek@aol.com</ShipNotificationEmail>
       <UOMWeight>LBS</UOMWeight>
       <UnitsOfMeasureLinear>IN</UnitsOfMeasureLinear>
       <Package>
         <PackageActualWeight>0.00396832071933</PackageActualWeight>
         <PackagingType>02</PackagingType>
         <PackageReference1>Order #731222</PackageReference1>
       </Package>
       <DeliveryAddress>
         <Address>
           <FirstName>SMAIL</FirstName>
           <LastName>FERRAD</LastName>
           <Address1>Rue 24 n26 Cite Nador</Address1>
           <City>El Madania</City>
           <State>16</State>
           <Country>DZ</Country>
           <StateAsString>Alger</StateAsString>
           <CountryAsString>Algeria</CountryAsString>
           <PostalCode>16000</PostalCode>
           <Phone>0551175851</Phone>
         </Address>
       </DeliveryAddress>
       <ShipperAddress>
         <UPSAccountNumber>4E15W9</UPSAccountNumber>
         <Address>
           <Company>Endoca USA</Company>
           <Name>Endoca USA 619-831-0156</Name>
           <Address1>2305 Historic Decatur Rd Suite 100</Address1>
           <City>San Diego</City>
           <State>CA</State>
           <Country>US</Country>
           <PostalCode>92106</PostalCode>
           <Phone>5098089727</Phone>
         </Address>
       </ShipperAddress>
     </Shipment>
     <Order>
       <UnitsOfMeasureWeight>LBS</UnitsOfMeasureWeight>
       <UnitsOfMeasureLinear>IN</UnitsOfMeasureLinear>
       <ShipmentOrderItem>
         <Name>RAW Hemp Oil Drops 300mg CBD+CBDa (3%)</Name>
         <Price>27.90</Price>
         <ExternalID>82</ExternalID>
         <Quantity>6</Quantity>
         <Total>167.40</Total>
       </ShipmentOrderItem>
       <PackageActualWeight>0.00396832071933</PackageActualWeight>
       <PaymentStatus>2</PaymentStatus>
       <ShippingChargesPaid>11.75</ShippingChargesPaid>
       <ShipMethod>Flat_1</ShipMethod>
       <OrderDate>5/3/17, 5:07 AM</OrderDate>
       <ItemsTotal>167.40</ItemsTotal>
       <Total>179.15</Total>
       <ItemsTax>0.00</ItemsTax>
       <OrderNumber>731222</OrderNumber>
       <ExternalID>731222</ExternalID>
       <BillingAddress>
         <FirstName>zino</FirstName>
         <LastName>malek</LastName>
         <Company>1958</Company>
         <Address1>1327 s bundy dr apt 5, los angeles</Address1>
         <City>los angeles</City>
         <State>CA</State>
         <Country>US</Country>
         <StateAsString>California</StateAsString>
         <CountryAsString>United States</CountryAsString>
         <PostalCode>90025</PostalCode>
         <Phone>4248889788</Phone>
         <EMail>zinomalek@aol.com</EMail>
       </BillingAddress>
       <ShippingAddress>
         <FirstName>SMAIL</FirstName>
         <LastName>FERRAD</LastName>
         <Company>1958</Company>
         <Address1>Rue 24 n26 Cite Nador</Address1>
         <City>El Madania</City>
         <State>16</State>
         <Country>DZ</Country>
         <StateAsString>Alger</StateAsString>
         <CountryAsString>Algeria</CountryAsString>
         <PostalCode>16000</PostalCode>
         <Phone>0551175851</Phone>
         <EMail>zinomalek@aol.com</EMail>
       </ShippingAddress>
     </Order>
   </ShipTransaction>
 </Request>';
		return $xml;
	}
	public static function callback() {
		self::init ();
		$responseVo = new ResponseMo ();
		$enId = RequestUtil::get ( 'enId' );
		$authStatus = $orderId = EncryptUtil::decryptString ( $enId, self::$secretToken );
		\DatoLogUtil::trace ( $orderId );
		$orderHistoryVo = new OrderHistoryVo ();
		$orderHistoryVo->orderId = $orderId;
		$orderShippingInfoVo = OrderHelper::getOrderShippingInfoVoByOrderId ( $orderId );
		
		$xml = null;
		$xml = file_get_contents ( 'php://input' );
		if ($authStatus && $xml) {
			try {
				$dom = new \DOMDocument ( '1.0' );
				$dom->preserveWhiteSpace = false;
				$dom->formatOutput = true;
				$dom->loadXML ( $xml );
				$xml = $dom->saveXML ();
				$data = new \SimpleXMLElement ( $xml );
				if ($trackingCode = $data->ShipTransaction->Shipment->Package->PackageTrackingNumber) {
					\DatoLogUtil::trace ( '$trackingCode:' . $trackingCode );
					$orderShippingInfoVo->trackingCode = $trackingCode;
					OrderHelper::insertUpdateOrderShippingInfo ( $orderShippingInfoVo );
					$orderHistoryVo->status = ShippingStatusEnum::FINISHED;
					$msg = 'Order successfully shipped by Shiprush callback. Tracking number:' . $trackingCode;
					$orderHistoryVo->description = $msg;
					OrderHelper::updateOrderShippingStatus ( $orderId, ShippingStatusEnum::FINISHED );
					ResponseHelper::setSuccess ( $responseVo, $msg );
				}
			} catch ( Exception $e ) {
				\DatoLogUtil::error ( $e->getMessage () );
				\DatoLogUtil::trace ( $e );
				// email callback error to system admin
				$msg = 'Order failed by Shiprush callback. Err:' . $e->getMessage ();
				$orderHistoryVo->status = ShippingStatusEnum::NEW_SHIP;
				$orderHistoryVo->description = $msg;
				ResponseHelper::setError ( $responseVo, $msg );
			}
		} else {
			$msg = 'invalid enId:' . $enId . ' orderId:' . $orderId . ' xml:' . $xml;
			ResponseHelper::setError ( $responseVo, $msg );
			\DatoLogUtil::error ( $msg );
			$orderHistoryVo->status = ShippingStatusEnum::NEW_SHIP;
			$orderHistoryVo->description = 'Order failed by Shiprush callback. Err:' . $msg;
		}
		OrderHelper::insertShippingOrderHistory ( $orderHistoryVo );
		return $responseVo;
	}
	private static function getUPSServiceTypeByShippingMethod($shippingMethod) {
		\DatoLogUtil::debug ( '+ getUPSServiceTypeByShippingMethod +' );
		\DatoLogUtil::debug ( '$shippingMethod:' . $shippingMethod );
		// USPS Priority Mail = U02
		// UPS 3 Day = 12
		// UPS 2 Day = 02
		// UPS Next Day Air = 01
		$upsServiceType = null;
		$shippingMethod = preg_replace ( '/[^0-9a-z]+/i', '', strtolower ( $shippingMethod ) );
		\DatoLogUtil::debug ( '$shippingMethod:' . $shippingMethod );
		switch ($shippingMethod) {
			// case 1 :
			case 'flatrate' :
			case 'freeshipping' :
				// USPS Priority Mail
				$upsServiceType = 'U02';
				break;
			// case 2 :
			case '3days' :
				// UPS 3 Day
				$upsServiceType = '12';
				break;
			// case 3 :
			case '2days' :
			// case 4 :
			case 'alaskahawaii' :
				// UPS 2 Day
				$upsServiceType = '02';
				break;
			// case 5 :
			case 'overnight' :
				// UPS Next Day Air
				$upsServiceType = '01';
				break;
			// case 6 :
			// case 'eu' :
			// break;
			// case 7 :
			// case 'denmark' :
			// break;
			// case 8 :
			// case 'europeancountriesoutsideeu' :
			// break;
			// case 9 :
			// case 'expresseucountries' :
			// break;
			// case 10 :
			// case 'expressdenmark' :
			// break;
			// case 11 :
			// case 'Global' :
			// break;
			default :
				
				break;
		}
		\DatoLogUtil::debug ( '$upsServiceType:' . $upsServiceType );
		\DatoLogUtil::debug ( '+ getUPSServiceTypeByShippingMethod +' );
		return $upsServiceType;
	}
}