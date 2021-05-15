<?php

namespace backend\service;

use backend\persistence\extend\dao\SalesReportDao;
use backend\persistence\extend\vo\SalesReportFilterVo;
use common\services\base\BaseService;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\DateTimeUtil;

class SalesReportService extends BaseService
{
    private $salesReportDao;

    public function __construct($context = null)
    {
        parent::__construct($context);
        $this->salesReportDao = new SalesReportDao ();
    }

    public function getOverviewByFilter(SalesReportFilterVo $filter)
    {
        return $this->salesReportDao->getOverviewByFilter($filter);
    }

    public function getOrderByFilter(SalesReportFilterVo $filter)
    {
        return $this->salesReportDao->getOrderByFilter($filter);
    }

    public function getTopProductByFilter(SalesReportFilterVo $filter)
    {
        return $this->salesReportDao->getTopProductByFilter($filter);
    }

    public function getTopCountryFilter(SalesReportFilterVo $filter)
    {
        return $this->salesReportDao->getTopCountryFilter($filter);
    }

    public function getDistinctTopCountryByFilter(SalesReportFilterVo $filter) {
    	return $this->salesReportDao->getDistinctTopCountryByFilter($filter);
    }
    
    public function exportReportExcel($datas, $regionList, $fileName)
    {

        $objPHPExcel = new \PHPExcel();

        $cacheMethod = \PHPExcel_CachedObjectStorageFactory::cache_to_sqlite3;
        $cacheSettings = array( ' memoryCacheSize ' => '512MB');
        \PHPExcel_Settings::setCacheStorageMethod($cacheMethod, $cacheSettings);

        // Set properties
        $objPHPExcel->getProperties()->setCreator("Endoca");
        $objPHPExcel->getProperties()->setLastModifiedBy("DATO EC");
        $objPHPExcel->getProperties()->setTitle("Endoca Sale Report");
        $objPHPExcel->getProperties()->setSubject("Office Endoca Sale Report");

        // Write Sheet overview
        $orderStatusList = $datas['orderStatusList'];
        $currencyList = $datas ["currencyList"];
        $overviewDatas = $datas['overview'];
        $overviewSheet = $objPHPExcel->setActiveSheetIndex(0);
        // Write header with merged cells
        $overviewSheet->setTitle('Overview');
        
        $overviewSheet->getCellByColumnAndRow(0,1)->setValue(Lang::get('Status'))->getStyle()->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
        		->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        $overviewSheet->mergeCellsByColumnAndRow(0,1,0,2);
        
        $c = 1;
        foreach ($regionList as $region) {
            $overviewSheet->getCellByColumnAndRow($c, 1)
                ->setValue($region->name)->getStyle()->getAlignment()
                ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $overviewSheet->mergeCellsByColumnAndRow($c, 1, $c + count($currencyList), 1);
            $j = 0;
            foreach ($currencyList as $currency){
            	$overviewSheet->getCellByColumnAndRow($c + $j, 2)->setValue(Lang::getWithFormat("Sales ({0})", $currency->code));
            	$overviewSheet->getColumnDimensionByColumn($c + $j)->setAutoSize(true);
            	$j++;
            }
            $overviewSheet->getCellByColumnAndRow($c + $j, 2)->setValue(Lang::get("# Orders"));
            $overviewSheet->getColumnDimensionByColumn($c + $j)->setAutoSize(true);
            $c += $j+1;
        }

        $r = 3;
        foreach ($orderStatusList as $orderStatus) {
            $c = 0;
            $overviewSheet->getCellByColumnAndRow($c, $r)->setValue($orderStatus->name);
            $overviewSheet->getStyle($overviewSheet->getCellByColumnAndRow($c, $r)->getCoordinate())
	            ->getAlignment()
	            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $overviewSheet->getColumnDimensionByColumn($c)->setAutoSize(true);
            $c++;
            foreach ($regionList as $region) {
            	$j = 0;
            	foreach ($currencyList as $currency){
	                $key = $orderStatus->id . "_" . $region->id . "_" . $currency->code;
	                $overviewSheet->getCellByColumnAndRow($c + $j, $r)
	                    ->setValue($overviewDatas [$key]->orderTotal);
	                $overviewSheet->getStyle($overviewSheet->getCellByColumnAndRow($c, $r)->getCoordinate())
	                    ->getAlignment()
	                    ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	                $j++;
            	}
            	$key = $orderStatus->id . "_" . $region->id . "_noOfOrders";
            	$overviewSheet->getCellByColumnAndRow($c + $j, $r)
            		->setValue($overviewDatas [$key]);
            	$overviewSheet->getStyle($overviewSheet->getCellByColumnAndRow($c + $j, $r)->getCoordinate())
	            	->getAlignment()
	            	->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            	$overviewSheet->getColumnDimensionByColumn($c + $j)->setAutoSize(true);
            	$c += $j+1;
            }
            $r++;
        }
        $orderSheet = new \PHPExcel_Worksheet($objPHPExcel, "Orders");
        $objPHPExcel->addSheet($orderSheet);
        $orderDatas = $datas["orderList"];
        $salesReportFilterVo = $datas["filter"];
        $headers = array(
            Lang::get ( 'Order ID' ),
            Lang::get ( 'MEGA ID' ),
            Lang::get ( 'Order Status' ),
            Lang::get ( 'Shipping Status' ),
            Lang::get ( 'Currency' ),
            Lang::get ( 'Region' ),
            Lang::get ( 'First Name' ),
            Lang::get ( 'Last Name' ),
            Lang::get ( 'User Email' ),
            Lang::get ( 'Cust Type' ),
            Lang::get ( 'User Type' ),
            Lang::get ( 'Shipping Method' ),
            Lang::get ( 'Shipping Country' ),
            Lang::get ( 'Payment Method' ),
            Lang::get ( 'Bill Country' ),
            Lang::get ( 'Coupon Code' ),
            Lang::get ( 'Shipping Title' ),
            Lang::get ( 'Tax Title' ),
            Lang::get ( 'Product Amt' ),
            Lang::get ( 'Discount Amt' ),
            Lang::get ( 'Coupon Amt' ),
            Lang::get ( 'Tax Amt' ),
            Lang::get ( 'Shipping Amt' ),
            Lang::get ( 'Total Amt' ),
            Lang::get ( 'Paid Amt' ),
            Lang::get ( 'CreatedDate' ),
            Lang::get ( 'UpdatedDate' )
        );
        
        $c=0;
        foreach ($headers as $header){
            $orderSheet->getCellByColumnAndRow($c, 1)
            ->setValue($header);
            $c ++;
        }

        $r=2;
        foreach ($orderDatas as $order){
            $orderSheet->getCellByColumnAndRow(0,$r)->setValue($order->id);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(0,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $orderSheet->getCellByColumnAndRow(1,$r)->setValue($order->megaId);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(1,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $orderSheet->getCellByColumnAndRow(2,$r)->setValue($order->orderStatusName);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(2,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $orderSheet->getCellByColumnAndRow(3,$r)->setValue($order->shippingStatusName);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(3,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $orderSheet->getCellByColumnAndRow(4,$r)->setValue($order->currencyCode);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(4,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(5,$r)->setValue($order->regionName);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(5,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(6,$r)->setValue($order->firstName);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(6,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(7,$r)->setValue($order->lastName);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(7,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(8,$r)->setValue($order->email);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(8,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(9,$r)->setValue($order->customerType);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(9,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(10,$r)->setValue($order->accountType);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(10,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(11,$r)->setValue($order->shippingMethod);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(11,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            if($order->shippingCountry == "Denmark"){
            	$orderSheet->getCellByColumnAndRow(12,$r)->setValue("Turkey");;
            }else{
            	$orderSheet->getCellByColumnAndRow(12,$r)->setValue($order->shippingCountry);
            }
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(12,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(13,$r)->setValue($order->paymentMethod);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(13,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(14,$r)->setValue($order->billingCountry);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(14,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(15,$r)->setValue($order->couponCode);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(15,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(16,$r)->setValue($order->shippingTitle);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(16,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(17,$r)->setValue($order->taxTitle);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(17,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(18,$r)->setValue(number_format($order->productAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(18,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(18,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(19,$r)->setValue(number_format($order->discountAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(19,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(19,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(20,$r)->setValue(number_format($order->couponAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(20,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(20,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(21,$r)->setValue(number_format($order->taxAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(21,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(21,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(22,$r)->setValue(number_format($order->shippingAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(22,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(22,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(23,$r)->setValue(number_format($order->totalAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(23,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(23,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(24,$r)->setValue(number_format($order->paidAmount,2));
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(24,$r)->getCoordinate())
                ->getNumberFormat()
                ->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER_00);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(24,$r)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

            $orderSheet->getCellByColumnAndRow(25,$r)->setValue($order->crDate);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(25,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            
            $orderSheet->getCellByColumnAndRow(26,$r)->setValue($order->mdDate);
            $orderSheet->getStyle($orderSheet->getCellByColumnAndRow(26,$r)->getCoordinate())
            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $r++;
        }
        
        if($salesReportFilterVo->startDate >= DateTimeUtil::string2MySqlDate (ApplicationConfig::get('salereport.start.date'), "d-m-Y" )){
        	$orderSheet->removeColumn('B',1);
        }

        $topProductSheet = new \PHPExcel_Worksheet($objPHPExcel, "Top Products");
        $objPHPExcel->addSheet($topProductSheet);
        $topProductDatas = $datas['topProduct'];

        $headers = array(
            Lang::get("Product"),
            Lang::get("Quantity")
        );

        $c=0;
        foreach ($headers as $header){
            $topProductSheet->getCellByColumnAndRow($c, 1)
                ->setValue($header);
                $topProductSheet->getStyle($orderSheet->getCellByColumnAndRow($c,1)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $c ++;
        }

        $r = 2;
        foreach ($topProductDatas as $product){
            $topProductSheet->getCellByColumnAndRow(0,$r)->setValue($product->name);
            $topProductSheet->getStyle($orderSheet->getCellByColumnAndRow(0,$r)->getCoordinate())
            	->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
            $topProductSheet->getColumnDimensionByColumn(0)->setAutoSize(true);
            $topProductSheet->getCellByColumnAndRow(1,$r)->setValue($product->quantity);
            $topProductSheet->getStyle($topProductSheet->getCellByColumnAndRow(1,$r)->getCoordinate())->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
            $topProductSheet->getStyle($topProductSheet->getCellByColumnAndRow(1,$r)->getCoordinate())->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $r++;
        }

        $topCountrySheet = new \PHPExcel_Worksheet($objPHPExcel, "Top Countries");
        $objPHPExcel->addSheet($topCountrySheet);
        $topCountryDatas = $datas['topCountry'];

        $headers = array(
            Lang::get("Country"),
            Lang::get("Total Order"),
            Lang::get("Paid Amt")
        );

        $c=0;
        foreach ($headers as $header){
        	if ($c==2){
        		$topCountrySheet->mergeCellsByColumnAndRow(2,1,2+count($currencyList),1);
        	} else {
        		$topCountrySheet->mergeCellsByColumnAndRow($c,1,$c,2);
        	}
            $topCountrySheet->getCellByColumnAndRow($c, 1)
                ->setValue($header);
            $topCountrySheet->getStyle($orderSheet->getCellByColumnAndRow($c,1)->getCoordinate())
                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
                ->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);;
            $c ++;
        }
        
        // Create cell for each currency.
        $c = 2;
        foreach ($currencyList as $currency){
        	$topCountrySheet->getCellByColumnAndRow($c, 2)
        		->setValue($currency->code);
        	$c++;
        }

        $countryList = $datas['countryList'];
        $r = 3;
        foreach ($countryList as $country){
        	// Write country name.
        	$topCountrySheet->getCellByColumnAndRow(0,$r)->setValue($country->name);
        	$topCountrySheet->getStyle($topCountrySheet->getCellByColumnAndRow(0,$r)->getCoordinate())
        		->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
        	$topCountrySheet->getColumnDimensionByColumn(0)->setAutoSize(true);
        	// Write order count.
        	$key = $country->code . "_noOfOrders";
        	$topCountrySheet->getCellByColumnAndRow(1,$r)->setValue($topCountryDatas[$key]);
        	$topCountrySheet->getStyle($topCountrySheet->getCellByColumnAndRow(1,$r)->getCoordinate())
        		->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        	$topCountrySheet->getColumnDimensionByColumn(1)->setAutoSize(true);
        	// Write paid amount for each currency.
        	$c = 2;
        	foreach ($currencyList as $currency){
        		$key = $country->code . "_" . $currency->code;
        		$countryReportVo = $topCountryDatas[$key];
        		$topCountrySheet->getCellByColumnAndRow($c,$r)->setValue($countryReportVo->paidAmount);
        		$topCountrySheet->getColumnDimensionByColumn($c)->setAutoSize(true);
        		$topCountrySheet->getStyle($topCountrySheet->getCellByColumnAndRow($c,$r)->getCoordinate())->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        		$topCountrySheet->getStyle($topCountrySheet->getCellByColumnAndRow($c,$r)->getCoordinate())->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
        		$c++;
        	}
        	$r++;
        }
        // Save Excel 2007 file
        $objWriter = new \PHPExcel_Writer_Excel2007($objPHPExcel);
        $objWriter->save(ApplicationConfig::get("export.tmp.path") . $fileName);
        return ApplicationConfig::get("export.tmp.path") . $fileName;
    }
}