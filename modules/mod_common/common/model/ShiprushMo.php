<?php

namespace common\model;

class ShiprushMo {
	public $postBackURL;
	public $postBackContentType;
	public $upsAccountNumber;
	public $upsServiceType;
	public $shipmentType;
	public $shipmentChgType;
	public $shipNotificationEmail;
	public $deliveryNotificationEmail;
	public $exceptionNotificationEmail;
	// Package
	public $unitsOfMeasureWeight;
	public $unitsOfMeasureLinear;
	public $uomWeight;
	public $packageActualWeight;
	public $packagingType;
	public $packageReference1;
	public $pkgLength;
	public $pkgWidth;
	public $pkgHeight;
	public $orderShipMethod;
	public $orderDate;
	// array of ShiprushOrderItemMo
	public $orderItemList;
	public $orderItemsTotal;
	public $orderItemsTax;
	public $shippingChargesPaid;
	public $orderTotalAmt;
	public $orderNumber;
	public $orderExternalID;
	public $paymentStatus;
	
	// Shipper Address
	public $storeName;
	public $storeCompany;
	public $storeAddress1;
	public $storeAddress2;
	public $storeCity;
	public $storeState;
	public $storeCountry;
	public $storeStateAsString;
	public $storeCountryAsString;
	public $storePostalCode;
	public $storePhone;
	public $storeEMail;
	
	// Delivery Address
	public $shipFirstName;
	public $shipLastName;
	public $shipCompany;
	public $shipAddress1;
	public $shipAddress2;
	public $shipCity;
	public $shipState;
	public $shipCountry;
	public $shipStateAsString;
	public $shipCountryAsString;
	public $shipPostalCode;
	public $shipPhone;
	public $shipEmail;
	// Billing Address
	public $billFirstName;
	public $billLastName;
	public $billCompany;
	public $billAddress1;
	public $billAddress2;
	public $billCity;
	public $billState;
	public $billCountry;
	public $billStateAsString;
	public $billCountryAsString;
	public $billPostalCode;
	public $billPhone;
	public $billEmail;
}