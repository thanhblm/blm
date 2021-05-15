<?php

namespace common\services\order;

use common\persistence\base\dao\OrderBaseDao;
use common\persistence\base\dao\OrderHistoryBaseDao;
use common\persistence\base\dao\OrderProductBaseDao;
use common\persistence\base\dao\OrderShipingInfoBaseDao;
use common\persistence\base\vo\CustomerVo;
use common\persistence\base\vo\OrderHistoryVo;
use common\persistence\base\vo\OrderProductVo;
use common\persistence\base\vo\OrderShipingInfoVo;
use common\persistence\base\vo\OrderVo;
use common\persistence\base\vo\PaymentTxnVo;
use common\persistence\extend\dao\OrderExtendDao;
use common\persistence\extend\dao\OrderHistoryExtendDao;
use common\persistence\extend\dao\OrderProductExtendDao;
use common\persistence\extend\vo\OrderExtendVo;
use common\persistence\extend\vo\OrderHistoryExtendVo;
use common\services\base\BaseService;
use common\helper\LocalizationHelper;
use common\persistence\extend\vo\OrderProductExtendVo;
use common\persistence\base\dao\OrderTotalBaseDao;
use common\persistence\base\vo\OrderTotalVo;
use core\database\SqlMapClient;
use common\persistence\base\dao\CartInfoBaseDao;
use common\persistence\base\vo\RegionVo;
use common\services\region\RegionService;
use core\libs\TCPDF\Pdf;
use core\utils\AppUtil;
use common\helper\DatoImageHelper;
use core\Lang;
use core\utils\DateTimeUtil;
use common\persistence\base\dao\PaymentTxnBaseDao;
use frontend\controllers\ControllerHelper;
use frontend\service\OrderHelper;
use frontend\service\CartHelper;
use common\config\PaymentMethodEnum;
use core\utils\SessionUtil;

class OrderService extends BaseService {
	private $orderDao;
	private $orderProductDao;
	private $orderProductSurchargeDao;
	private $productSurchargeDao;
	private $orderHistoryDao;
	private $paymentTxnDao;
	public function __construct($context = array()) {
		parent::__construct ( $context );
		$this->orderDao = new OrderExtendDao ();
		$this->orderHistoryDao = new OrderHistoryExtendDao ();
		$this->paymentTxnDao = new PaymentTxnBaseDao ();
	}
	public function updateOrder(OrderVo $order) {
		$order->mdDate= date ( 'Y-m-d H:i:s' );
		return $this->orderDao->updateDynamicByKey ( $order );
	}
	public function getOrderVoByKey(OrderVo $filter) {
		return $this->orderDao->getOrderByKey ( $filter );
	}
	public function getOrderByKey(OrderExtendVo $filter) {
		// get basic info of order
		$orderExtendVo = $this->orderDao->getOrderByKey ( $filter );
		if ($orderExtendVo === null) {
			return null;
		}
		$orderProductFilter = new OrderProductVo ();
		$orderProductFilter->orderId = $filter->id;
		$orderProductDao = new OrderProductExtendDao ();
		$orderExtendVo->orderProducts = $orderProductDao->getOrderProductByKey ( $orderProductFilter );
		
		$orderHistoryDao = new OrderHistoryExtendDao ();
		$orderHistoryFilter = new OrderHistoryExtendVo ();
		$orderHistoryFilter->orderId = $filter->id;
		$orderHistoryFilter->order_by = 'crDate desc';
		$orderExtendVo->orderHistories = $orderHistoryDao->getByFilter ( $orderHistoryFilter ); // getByFilter
		
		$orderTotalVo = new OrderTotalVo ();
		$orderTotalVo->order_by = 'id asc';
		$orderTotalVo->orderId = $filter->id;
		$orderExtendVo->orderTotal = $this->selectOrderTotalByKey ( $orderTotalVo );
		return $orderExtendVo;
	}
	public function getOrders(OrderExtendVo $filter) {
		return $this->orderDao->getByFilter ( $filter );
	}
	public function countOrders(OrderExtendVo $filter) {
		return $this->orderDao->getCountByFilter ( $filter );
	}
	public function deleteOrder(OrderVo $orderVo) {
		$sqlClient = new SqlMapClient ( $this->context );
		
		$orderBaseDao = new OrderBaseDao ( $this->context, $sqlClient );
		$orderProductBaseDao = new OrderProductBaseDao ( $this->context, $sqlClient );
		$orderHistoryDao = new OrderHistoryBaseDao ( $this->context, $sqlClient );
		$orderTotalDao = new OrderTotalBaseDao ( $this->context, $sqlClient );
		$orderShipingInfoDao = new OrderShipingInfoBaseDao ( $this->context, $sqlClient );
		
		// Begin transaction.
		$sqlClient->startTransaction ();
		try {
			// delete all order product that belong
			$orderProductFilter = new OrderProductVo ();
			$orderProductFilter->orderId = $orderVo->id;
			$orderProductVos = $orderProductBaseDao->selectByFilter ( $orderProductFilter );
			foreach ( $orderProductVos as $orderProductVo ) {
				$orderProductBaseDao->deleteByKey ( $orderProductVo );
			}
			// delete all order history that belong
			$orderHistoryFilter = new OrderHistoryVo ();
			$orderHistoryFilter->orderId = $orderVo->id;
			$orderHistoryVos = $orderHistoryDao->selectByFilter ( $orderHistoryFilter );
			foreach ( $orderHistoryVos as $orderHistoryVo ) {
				$orderHistoryDao->deleteByKey ( $orderHistoryVo );
			}
			// delete all order surcharge that belong
			$orderTotalFilter = new OrderTotalVo ();
			$orderTotalFilter->orderId = $orderVo->id;
			$orderTotalVos = $orderTotalDao->selectByFilter ( $orderTotalFilter );
			foreach ( $orderTotalVos as $orderTotalVo ) {
				$orderTotalDao->deleteByKey ( $orderTotalVo );
			}
			// delete all order shipping info that belong
			$orderShipingInfoFilter = new OrderShipingInfoVo ();
			$orderShipingInfoFilter->orderId = $orderVo->id;
			$orderShipingInfoVos = $orderShipingInfoDao->selectByFilter ( $orderShipingInfoFilter );
			foreach ( $orderShipingInfoVos as $orderShipingInfoVo ) {
				$orderShipingInfoDao->deleteByKey ( $orderShipingInfoVo );
			}
			// delete order
			$orderBaseDao->deleteByKey ( $orderVo );
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function getOrdersByCustomerSalesRep(CustomerVo $customerVo) {
		return $this->orderDao->getOrdersByCustomerSalesRep ( $customerVo );
	}
	public function getCountOrdersByCustomerSalesRep(CustomerVo $customerVo) {
		return $this->orderDao->getCountOrdersByCustomerSalesRep ( $customerVo );
	}
	public function getOrdersByCustomer(OrderVo $orderVo) {
		return $this->orderDao->getOrdersByCustomer ( $orderVo );
	}
	public function getCountOrdersByCustomer(OrderVo $orderVo) {
		return $this->orderDao->getCountOrdersByCustomer ( $orderVo );
	}
	
	public function getCountOrdersByCustomerAndCouponCode(OrderVo $orderVo) {
		return $this->orderDao->getCountOrdersByCustomerAndCouponCode ( $orderVo );
	}
	
	public function getOrdersCustomerByKeySalesRep(OrderExtendVo $filter) {
		// get basic info of order
		$orderExtendVo = $this->orderDao->getOrderByKey ( $filter );
		$orderProductFilter = new OrderProductExtendVo ();
		$orderProductFilter->orderId = $filter->id;
		$orderProductFilter->languageCode = LocalizationHelper::getLangCode ();
		$orderProductDao = new OrderProductExtendDao ();
		$orderExtendVo->orderProducts = $orderProductDao->getOrderProductCustomerByKey ( $orderProductFilter );
		
		$orderHistoryDao = new OrderHistoryExtendDao ();
		$orderHistoryFilter = new OrderHistoryExtendVo ();
		$orderHistoryFilter->orderId = $filter->id;
		$orderExtendVo->orderHistories = $orderHistoryDao->getByFilter ( $orderHistoryFilter ); // getByFilter
		return $orderExtendVo;
	}
	public function insertOrderHistory(OrderHistoryVo $orderHistoryVo) {
		$this->orderHistoryDao->insertDynamic ( $orderHistoryVo );
	}
	public function getOrderHistorysByOrder(OrderExtendVo $filter) {
		$orderHistoryDao = new OrderHistoryExtendDao ();
		$orderHistoryFilter = new OrderHistoryExtendVo ();
		$orderHistoryFilter->orderId = $filter->id;
		$orderHistoryFilter->order_by = "crDate desc";
		$orderHistories = $orderHistoryDao->getByFilter ( $orderHistoryFilter ); // getByFilter
		return $orderHistories;
	}
	public function insertOrderShippingInfo($orderShippingInfoVo) {
		$orderShippingInfoDao = new OrderShipingInfoBaseDao ();
		$orderShippingInfoDao->insertDynamic ( $orderShippingInfoVo );
	}
	public function deleteOrderShippingInfo($orderShippingInfoVo) {
		$orderShippingInfoDao = new OrderShipingInfoBaseDao ();
		$orderShippingInfoDao->deleteByKey ( $orderShippingInfoVo );
	}
	public function getOrderShippingInfoByKey($orderShippingInfoVo) {
		$orderShippingInfoDao = new OrderShipingInfoBaseDao ();
		return $orderShippingInfoDao->selectByKey ( $orderShippingInfoVo );
	}
	public function selectOrderTotalByKey(OrderTotalVo $orderTotalVo) {
		$orderTotalDao = new OrderTotalBaseDao ();
		return $orderTotalDao->selectByFilter ( $orderTotalVo );
	}
	public function createOrder(ShoppingCartModel $shoppingCartModel) {
		$sqlClient = new SqlMapClient ( $this->context );
		$orderDao = new OrderBaseDao ( $this->context, $sqlClient );
		$orderProductDao = new OrderProductBaseDao ( $this->context, $sqlClient );
		$orderTotalDao = new OrderTotalBaseDao ( $this->context, $sqlClient );
		$cartInfoDao = new CartInfoBaseDao ( $this->context, $sqlClient );
		// Start transaction.
		$sqlClient->startTransaction ();
		try {
			// Insert order.
			$orderId = $orderDao->insertDynamic ( $shoppingCartModel->order );
			// Insert product orders.
			foreach ( $shoppingCartModel->products->getArray () as $productOrderVo ) {
				$productOrderVo->orderId = $orderId;
				$orderProductDao->insertDynamic ( $productOrderVo );
			}
			// Insert order totals.
			foreach ( $shoppingCartModel->orderTotals->getArray () as $orderTotalVo ) {
				$orderTotalVo->orderId = $orderId;
				$orderTotalDao->insertDynamic ( $orderTotalVo );
			}
			// Update cart info.
			$cartInfoVo = $shoppingCartModel->cart;
			$cartInfoVo->orderId = $orderId;
			$cartInfoDao->updateDynamicByKey ();
			// Commit transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			// Rollback transaction.
			$sqlClient->rollback ();
			throw $e;
		}
	}
	public function updateOrderStatusByTransaction(OrderVo $orderVo, OrderHistoryVo $orderHistoryVo, PaymentTxnVo $paymentTxnVo) {
		try {
			$sqlClient = new SqlMapClient ( $this->context );
			
			$orderBaseDao = new OrderBaseDao ( $this->context, $sqlClient );
			$orderHistoryDao = new OrderHistoryBaseDao ( $this->context, $sqlClient );
			$paymentTxnDao = new PaymentTxnBaseDao ( $this->context, $sqlClient );
			// Begin transaction.
			$sqlClient->startTransaction ();
			\DatoLogUtil::debug ( $orderVo );
			$tmpOrderVo = AppUtil::cloneObj ( $orderVo );
			
			$orderSurcharges = SessionUtil::get ( "orderSurcharge" );
			$listOrderProduct = SessionUtil::get ( "listOrderProduct" );
			
			$tmpOrderVo->paymentMethod = OrderHelper::getPaymentMethodNameById ( $orderVo->paymentMethod );
			$tmpOrderVo->shippingMethod = OrderHelper::getShippingMethodNameById ( $orderVo->shippingMethod );
			$tmpOrderVo->shippingMethodItem = OrderHelper::getShippingMethodItemNameByBase64 ( $orderVo->shippingMethodItem, $orderVo->shippingMethod );
			if (CartHelper::isFreeShipping($orderSurcharges, $listOrderProduct, $orderVo) && "Free Shipping" == $tmpOrderVo->shippingMethodItem) {
				$tmpOrderVo->shippingMethod = $tmpOrderVo->shippingMethodItem;
			}
			\DatoLogUtil::debug ( $orderVo );
			$orderBaseDao->updateDynamicByKey ( $tmpOrderVo );
			// Clone order history.
			$cloneOrderHistoryVo = AppUtil::cloneObj($orderHistoryVo);
			$cloneOrderHistoryVo->description = "Status Update";
			$orderHistoryDao->insertDynamic ( $cloneOrderHistoryVo );
			// Insert order history.
			$resultArr['orderHistoryId'] = $orderHistoryDao->insertDynamic ( $orderHistoryVo );
			\DatoLogUtil::debug ( $resultArr );
			$filter = new PaymentTxnVo ();
			$filter->cartInfoId = $paymentTxnVo->cartInfoId;
			$count = $paymentTxnDao->countByFilter ( $filter );
			\DatoLogUtil::trace ( $paymentTxnVo );
			if ($count > 0) {
				$paymentTxnDao->updateDynamicByKey ( $paymentTxnVo );
			} else {
				$paymentTxnDao->insertDynamicWithId ( $paymentTxnVo );
			}
			$cartInfoVo = CartHelper::getCartInfoVoByOrderId ( $orderVo->id );
			CartHelper::updateCartInfoVoByOrderVo ( $cartInfoVo, $orderVo );
			// End transaction.
			$sqlClient->endTransaction ();
		} catch ( \Exception $e ) {
			// rollback transaction.
			$sqlClient->rollback ();
			\DatoLogUtil::error ( $e->getMessage () );
			\DatoLogUtil::trace ( $e );
			throw $e;
		}
		return $resultArr;
	}
	public function exportPdfOrder(OrderExtendVo $order) {
		define ( 'K_PATH_IMAGES', '' );
		$regionService = new RegionService ();
		$regionVo = new RegionVo ();
		$regionVo->id = $order->regionId;
		$region = $regionService->getById ( $regionVo );
		
		$paymentMethod = $order->paymentMethod;
		switch ($order->paymentMethodId) {
			case PaymentMethodEnum::BANK_TRANSTER :
				break;
			default :
				$paymentMethod = Lang::get("Credit Card");
				break;
		}
		
		$shippingMethod = $order->shippingMethod . ' : ' . $order->shippingMethodItem;
		
		$pdf = new Pdf ();
		$fontFace = 'notosans';
		
		$spcTotals = 5 * count ( $order->orderTotal ) + 5;
		$pdf->SetCreator ( '' );
		$pdf->SetAuthor ( 'ENDOCA' );
		$pdf->SetTitle ( sprintf ( 'Invoice %d', $order->id ) );
		
		// page
		$pdf->SetMargins ( 15, 30, 15 );
		$pdf->SetFont ( $fontFace, '', 12 );
		$pdf->SetDefaultMonospacedFont ( 'courier' );
		$pdf->SetAutoPageBreak ( false );
		$pdf->startPageGroup ();
		
		$margin = ( object ) $pdf->getMargins ();
		$innerPageWidth = $pdf->getPageWidth () - $margin->right;
		
		// header
		$pdf->SetHeaderMargin ( 5 );
		$pdf->setHeaderFont ( Array (
				$fontFace,
				'',
				9 
		) );
		$headerText = $region->invoiceHeader;
		$headerText = strip_tags ( $headerText );
		$headerText = str_replace ( "\r\n\r\n", "\r\n", $headerText );
		if (AppUtil::isEmptyString ( $region->invoiceLogo ) || is_null ( $region->invoiceLogo )) {
			$pdf->setHeaderData ( '', '', null, $headerText, array (
					0 
			), array (
					255 
			) );
		} else {
			$imageMo = DatoImageHelper::getImageInfoById ( $region->invoiceLogo );
			$imageUrl = DatoImageHelper::getUrl ( $imageMo );
			$size = getimagesize ( $imageUrl );
			$h = 15;
			$w = $h * $size [0] / $size [1];
			$pdf->setHeaderData ( $imageUrl, min ( $w, $innerPageWidth / 3 ), null, $headerText, array (
					0 
			), array (
					255 
			) );
		}
		
		// footer
		$pdf->setPrintFooter ( false );
		$footerMargin = 10;
		$footerStart = $pdf->getPageHeight () - $spcTotals - $footerMargin;
		
		$h = 0;
		
		$colTitles = [ 
				Lang::get ( 'Code' ),
				Lang::get ( 'Description' ),
				Lang::get ( 'Qty' ),
				Lang::get ( 'Retail' ),
				Lang::get ( 'Price' ),
				Lang::get ( 'Total' ) 
		];
		$colAlign = [ 
				'L',
				'L',
				'C',
				'R',
				'R',
				'R' 
		];
		$colWidths = [ 
				0,
				20,
				80,
				16,
				22,
				22,
				25 
		];
		$cols = [ ];
		foreach ( $colWidths as $i => $w )
			$cols [$i] = $i ? $cols [$i - 1] + $w : 14;
		$cols [] = $pdf->getPageWidth () - $cols [0];
		
		$colValues = array (
				function ($pr) {
					return $pr->productCode;
				},
				function ($pr) {
					return $pr->name;
				},
				function ($pr) {
					return $pr->quantity;
				},
				function ($pr) {
					return $pr->basePrice;
				},
				function ($pr) {
					return $pr->price;
				},
				function ($pr) {
					return $pr->price;
				} 
		);
		$pdfInfoBox = function ($x, $y, $w, $label, $text, $alias = false) use ($pdf) {
			$pdf->RoundedRect ( $x, $y, $w, 10, 3 );
			
			$fontFace = $pdf->getFontFamily ();
			$fontStyle = $pdf->getFontStyle ();
			$fontSize = $pdf->getFontSize ();
			
			$pdf->SetXY ( $x, $y + 0.5 );
			$pdf->SetTextColor ( 100 );
			$pdf->SetFont ( $fontFace, 'B', '7' );
			$pdf->Cell ( $w, 4, $label, 0, 0, 'C' );
			
			$pdf->SetTextColor ( 0 );
			$pdf->SetXY ( $alias ? $x + 6 : $x, $y + 5.5 );
			$pdf->SetFont ( $fontFace, 'B', '8' );
			$pdf->Cell ( $w, 4, $text, 0, 0, $alias ? 'L' : 'C' );
			
			$pdf->Line ( $x, $y + 4.5, $x + $w, $y + 4.5 );
			
			$pdf->SetFont ( $fontFace, $fontStyle, $fontSize );
		};
		
		$pdfOutputIntro = function ($addPage = true) use ($pdf, $h, $margin, $cols, $colTitles, $colAlign, $fontFace, $innerPageWidth, $order, $pdfInfoBox, $paymentMethod, $shippingMethod, $footerMargin) {
			
			$h = $margin->top;
			if ($addPage)
				$pdf->AddPage ( '', '', true );
				
				// info
			$pdfInfoBox ( 14, $h, 26, Lang::get ( 'Invoice' ), sprintf ( 'Nr. %s', $order->id ) );
			$pdfInfoBox ( 40, $h, 27, Lang::get ( 'Date' ), DateTimeUtil::mySqlStringDate2String ( $order->crDate, DateTimeUtil::getDateFormat () ) );
			$pdfInfoBox ( 67, $h, 44, Lang::get ( 'Payment Method' ), $paymentMethod );
			$pdfInfoBox ( 111, $h, 64, Lang::get ( 'Shipping Method' ), $shippingMethod );
			$pdfInfoBox ( 175, $h, 20, Lang::get ( 'Page' ), $pdf->getPageNumGroupAlias () . '/' . $pdf->getPageGroupAlias (), true );
			
			$h += 15;
			
			$boxHeight = 35;
			
			// bill to
			$pdf->SetXY ( $margin->left, $h + 3 );
			$pdf->SetLeftMargin ( $margin->left + 1 );
			$pdf->SetFont ( $fontFace, 'B', '8' );
			$pdf->Write ( 4, Lang::get ( 'Bill To:' ) . "\n" );
			$pdf->SetLeftMargin ( $margin->left + 4 );
			$pdf->SetFont ( $fontFace, '', '9' );
			$text = $order->billFirstName . ' ' . $order->billLastName;
			$text .= "\n" . $order->billAddress;
			$text .= "\n" . $order->billCity . ' ' . $order->billState.' '.$order->billZipcode;
			$text .= "\n" . $order->billCountry;
			$text = str_replace ( "N/A", "", $text );
			if ($order->billEmail)
				$text .= "\n" . 'Email: ' . $order->billEmail;
			if ($order->billPhone)
				$text .= "\n" . 'Phone: ' . $order->billPhone;
			$pdf->MultiCell ( $innerPageWidth * 4 / 9, 30, $text, 0, 'L' );
			$pdf->SetLeftMargin ( 10 );
			$boxHeight = max ( $boxHeight, $pdf->GetY () - $h + 2 );
			
			// ship to
			$pdf->SetXY ( $margin->left + 1, $h + 3 );
			$pdf->SetLeftMargin ( $innerPageWidth * 5 / 9 + 1 );
			$pdf->SetFont ( $fontFace, 'B', '8' );
			$pdf->Write ( 4, Lang::get ( 'Ship To:' ) . "\n" );
			$pdf->SetLeftMargin ( $innerPageWidth * 5 / 9 + 4 );
			$pdf->SetFont ( $fontFace, '', '9' );
			$text = $order->shipFirstName . ' ' . $order->shipLastName;
			$text .= "\n" . $order->shipAddress;
			$text .= "\n" . $order->shipCity . ' ' . $order->shipState.' '. $order->shipZipcode;
			$text .= "\n" . $order->shipCountry;
			$text = str_replace ( "N/A", "", $text );
			if ($order->shipEmail)
				$text .= "\n" . 'Email: ' . $order->shipEmail;
			if ($order->shipPhone)
				$text .= "\n" . 'Phone: ' . $order->shipPhone;
			$pdf->MultiCell ( $innerPageWidth * 4 / 9, 30, $text, 0, 'L' );
			$pdf->SetLeftMargin ( 10 );
			$boxHeight = max ( $boxHeight, $pdf->GetY () - $h + 2 );
			
			$pdf->RoundedRect ( 14, $h, $innerPageWidth * 4 / 9, $boxHeight - 5, 4 );
			$pdf->RoundedRect ( $innerPageWidth * 5 / 9, $h, $innerPageWidth * 4 / 9, $boxHeight - 5, 4 );
			
			$h += $boxHeight;
			
			// entries
			$pdf->SetFont ( $fontFace, '', '9' );
			$pdf->RoundedRect ( 14, $h, $pdf->getPageWidth () - 28, $pdf->getPageHeight () - $h - $footerMargin, 4 );
			
			foreach ( $colTitles as $i => $title ) {
				$x = $cols [$i] + 2;
				$w = floor ( $cols [$i + 1] - $x ) - 4;
				$pdf->writeHTMLCell ( $w, 3, $x, $h + 2, '<b>' . $title . '</b>', 0, 0, false, true, $colAlign [$i] );
			}
			$pdf->Line ( 14, $h + 7.5, $pdf->getPageWidth () - 14, $h + 7.5 );
			
			$h += 10;
			
			return $h;
		};
		
		$pdfOutputTotals = function () use ($pdf, $footerStart, $order, $region) {
			$totalTitle = array (
					'discount' => Lang::get ( 'Cart Discount' ),
					'subtotal' => Lang::get ( 'Subtotal' ),
					'coupon' => Lang::get ( 'Discount Coupon' ),
					// 'taxtotal' => purlRegion::taxName($order->region),
					'total' => Lang::get ( 'Grand Total' ) 
			);
			
			$pdf->Line ( 14, $footerStart, $pdf->getPageWidth () - 14, $footerStart );
			$y = $footerStart + 3;
			
			$invoiceComment = $order->invoiceComment ? $order->invoiceComment : $region->invoiceComment;
			if (! AppUtil::isEmptyString ( $invoiceComment )) {
				$pdf->writeHTMLCell ( 90, 5, 17, $y, '<b>' . Lang::get ( 'Comment:' ), 0, 0, false, true, 'L' );
				$pdf->SetFont ( $fontFace, '', '8' );
				$pdf->writeHTMLCell ( 90, 25, 17, $y + 5, nl2br ( $invoiceComment ), 0, 0, false, true, 'L' );
				$pdf->SetFont ( $fontFace, '', '9' );
			}
			
			foreach ( $order->orderTotal as $orderTotal ) {
				
				$pdf->SetXY ( 56, $y );
				
				if ($orderTotal->type == 'coupon') {
					$pdf->writeHTMLCell ( 105, 3, 56, $y, '<b>' . $orderTotal->title . ' [' . $order->couponCode . '] :</b>', 0, 0, false, true, 'R' );
				} else {
					$subtitle = ' ';
					if (! AppUtil::isEmptyString ( $orderTotal->subtitle )) {
						$subtitle .= '[' . $orderTotal->subtitle . ']';
					}
					$pdf->writeHTMLCell ( 105, 3, 56, $y, '<b>' . $orderTotal->title . $subtitle . ' :</b>', 0, 0, false, true, 'R' );
				}
				
				$pdf->Cell ( 25, 3, ControllerHelper::showProductPrice ( $orderTotal->value, $order->regionId ), 0, 0, 'R' );
				$y += 5;
			}
		};
		
		$topMargin = $y = $pdfOutputIntro ();
		
		$pdf->setAutoPageBreak ( true, $footerMargin );
		$pdf->setTopMargin ( $topMargin );
		
		foreach ( $order->orderProducts as $pr ) {
			$pr->price = ControllerHelper::showProductPrice ( $pr->price, $order->regionId );
			$pr->basePrice = ControllerHelper::showProductPrice ( $pr->basePrice, $order->regionId );
			if ($y > $footerStart - $footerMargin)
				$y = $pdfOutputIntro ();
			
			$currentPage = $pdf->getPage ();
			$nextY = 0;
			$nextPage = $currentPage;
			foreach ( $colValues as $i => $callback ) {
				$x = $cols [$i] + 2;
				$w = floor ( $cols [$i + 1] - $x ) - 4;
				$pdf->setPage ( $currentPage );
				$pdf->SetXY ( $x, $y );
				$pdf->writeHTMLCell ( $w, 3.2, $x, $y, $callback ( $pr ), 0, 1, false, true, $colAlign [$i] );
				if ($pdf->getPage () > $nextPage) {
					$nextPage = $pdf->getPage ();
					$nextY = $pdf->GetY ();
				} else if ($pdf->getPage () == $nextPage) {
					$nextY = max ( $nextY, $pdf->GetY () );
				}
			}
			// draw header on new pages
			for($i = $currentPage; $i < $nextPage; $i ++) {
				$pdf->setPage ( $i );
				$pdfOutputIntro ( false );
			}
			$y = $nextY;
			$pdf->setPage ( $nextPage );
			$pdf->SetXY ( $cols [0] + 2, $y );
		}
		$pdf->setAutoPageBreak ( false );
		
		if ($y > $footerStart - $footerMargin)
			$pdfOutputIntro ();
		
		$pdfOutputTotals ( $pdf, $spcTotals );
		
		$pdf->Output ( 'invoice-' . $order->id . '.pdf', 'I' );
	}
	public function getPendingOrders(OrderExtendVo $orderExtendVo) {
		$result = $this->orderDao->getPendingOrders ( $orderExtendVo );
		return $result;
	}
	public function getPaidOrdersTwoWeeksAgo(){
		$result = $this->orderDao->getPaidOrdersTwoWeeksAgo();
		return $result;
	}
}