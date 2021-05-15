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
use core\config\ApplicationConfig;
use core\config\FConstants;
use core\config\ModuleConfig;
use core\libs\plates\Engine;
use core\utils\AppUtil;
use core\utils\RouteUtil;
use core\workflow\ContextBase;
use core\workflow\Task;
use common\persistence\extend\vo\OrderExtendVo;

class GenerateReservedOrderCsvFileTask implements Task
{

    public function execute(ContextBase &$context)
    {
        try {
            $context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::SUCCESS);
            $erdtSv = new ErdtService();
            $totalOrders = $erdtSv->getCountReservedShippedOrders();
            if (empty($totalOrders) && 0 == $totalOrders) {
                \DatoLogUtil::info("There's no orders to ship.");
                return false;
            }

            $fileName = "ORDERS_" . date("Ymd_his");
            $orderIds = array();
            $orderExtendVo = new OrderExtendVo();
            $orderExtendVo->order_by = " id asc ";
            $reservedOrders = $erdtSv->getReservedShippedOrders($orderExtendVo);

            $data = array(
                "orderList" => $reservedOrders,
                "delimiter" => ";",
                "enclosure" => '"'
            );
            $templatePath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule())[FConstants::MODULE_PATH] . DS . "backend" . DS . "config" . DS . "templates";
            $templateName = "dk_export_csv_template";
            $dirPath = AppUtil::defaultIfEmpty(ApplicationConfig::get("export.tmp.path"));
            $fullPathFile = $dirPath . $fileName . ".csv";
            FileUtil::createFileFromTemplate($data, $fullPathFile, $templatePath, $templateName);

            $context->set(Attributes::FILE_NAME, $fileName . ".csv");
            $context->set(Attributes::FILE_PATH, $fullPathFile);
            \DatoLogUtil::devInfo($context);
        } catch (Exception $e) {
            $context->set(Attributes::ATTR_ERROR_CODE, ErrorCodes::ERROR);
            $context->set(Attributes::ATTR_ERROR_MESSAGE, $e->getMessage());
            return false;
        }
    }
}