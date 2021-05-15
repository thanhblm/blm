<?php

namespace common\utils;

use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\libs\plates\Engine;
use core\utils\AppUtil;
use core\utils\RouteUtil;

class FileUtil
{
    public static function loadFile($filePath)
    {
        require_once $filePath;
    }

    public static function loadWidgetController($widgetContentInfo)
    {
        $widgetContentData = ( array )$widgetContentInfo;
        $mod = RouteUtil::getRoute()->getModule();
        $controller = $widgetContentData ['widgetController'];
        $modulePath = ModuleConfig::getModuleConfig($mod) ['MODULE_PATH'];
        $widgetFile = $modulePath . DS . str_replace('mod_', '', $mod) . DS . "widgets" . DS . $controller . DS . $controller . '.php';
        include_once $widgetFile;
    }

    public static function loadWidgetForm($widgetContentInfo, $widgetContentLangs)
    {
        $widgetContentData = ( array )$widgetContentInfo;
        $controller = $widgetContentData ['widgetController'];
        $mod = RouteUtil::getRoute()->getModule();
        $modulePath = ModuleConfig::getModuleConfig($mod) ['MODULE_PATH'];
        $widgetFile = $modulePath . DS . str_replace('mod_', '', $mod) . DS . "widgets" . DS . $controller . DS . 'form' . DS . 'form.php';
        include $widgetFile;
    }

    public static function loadWidgetView($widgetContentInfo, $setting)
    {
        $widgetContentData = ( array )$widgetContentInfo;
        $mod = RouteUtil::getRoute()->getModule();
        $controller = $widgetContentData ['widgetController'];
        $modulePath = ModuleConfig::getModuleConfig($mod) ['MODULE_PATH'];
        $widgetFile = $modulePath . DS . str_replace('mod_', '', $mod) . DS . "widgets" . DS . $controller . DS . 'view' . DS . 'view.php';
        include $widgetFile;
    }

    public static function log($message, $file = 'log.txt')
    {
        if (is_array($message)) {
            $mes = "Array content \n";
            foreach ($message as $k => $v) {
                if (is_array($v)) {
                    $mes .= "\tarray[$k] = array(" . join(', ', $v) . ")\n";
                } else {
                    $mes .= "\tarray[$k] = $v\n";
                }
            }
            $message = $mes;
        } else if (is_object($message)) {
            $objectName = get_class($message);
            $mes = "$objectName object content \n";
            foreach ($message as $k => $v) {
                $mes .= "\t$objectName->$k = {$message->$k}\n";
            }
            $message = $mes;
        }
        $message = "[" . date('d-m h:m:s') . "] " . $message;
        $log_file = ROOT . DS . $file;
        $fp = @fopen($log_file, "a");
        if (!is_resource($fp))
            return false;
        @fwrite($fp, $message . "\n");
        @fclose($fp);
    }

    public static function getFileList($dir)
    {
        return scandir($dir, SCANDIR_SORT_ASCENDING);
    }

    public static function deleteDir($dirPath)
    {
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        if (is_dir($dirPath)) {
            rmdir($dirPath);
        }
    }

    public static function coppyDir($srcDir, $desDir)
    {
        if (substr($srcDir, strlen($srcDir) - 1, 1) != '/') {
            $srcDir .= '/';
        }
        if (substr($desDir, strlen($desDir) - 1, 1) != '/') {
            $desDir .= '/';
        }
        mkdir($desDir);
        $dirSrc = opendir($srcDir);
        while (false !== ($file = readdir($dirSrc))) {
            if (($file != '.') && ($file != '..')) {
                if (is_dir($srcDir . $file)) {
                    self::deleteDir($srcDir . $file, $desDir . $file);
                } else {
                    copy($srcDir . $file, $desDir . $file);
                }
            }
        }
        closedir($dirSrc);
    }

    public static function exportCsvFromObjects($objects, $type, $fileName = null)
    {
        if (!is_array($objects)) {
            throw new \Exception ("Input required array!");
        }
        if (!class_exists($type)) {
            throw new \Exception ("The class [$type] doesn't exists.");
        }
        if (!isset ($objects [0])) {
            $objects = array(
                new $type ()
            );
        }
        if (gettype($objects [0]) != "object") {
            throw new \Exception ("Input requied List of Object");
        }
        $objInfoHeading = get_object_vars($objects [0]);
        $microtime = str_replace(".", "-", microtime());
        $microtime = str_replace(" ", "-", $microtime);
        if (empty ($fileName)) {
            $fileName = "file-name-export-" . $microtime . ".csv";
        }
        $pathExport = AppUtil::defaultIfEmpty(ApplicationConfig::get("export.tmp.path"));
        $fileName = $pathExport . $fileName;
        $file = fopen($fileName, "w");
        $headingArray = array();
        foreach ($objInfoHeading as $key => $val) {
            if ("start_record" != $key && "end_record" != $key && "order_by" != $key) {
                $headingArray [] = $key;
            }
        }
        fputcsv($file, $headingArray);
        foreach ($objects as $object) {
            $valuesArray = array();
            $objInfo = get_object_vars($object);
            foreach ($objInfo as $key => $val) {
                if ("start_record" != $key && "end_record" != $key && "order_by" != $key) {
                    $valuesArray [] = AppUtil::defaultIfEmpty($val);
                }
            }
            fputcsv($file, $valuesArray);
        }
        fclose($file);
        return $fileName;
    }

    public static function exportCsv($prefix = "", $headMapping = array(), $filterVo, $serviceObj, $method)
    {
        $limit = 200;
        $startRecord = 0;
        $hasHeading = true;
        $dirPath = AppUtil::defaultIfEmpty(ApplicationConfig::get("export.tmp.path"));
        $fullPathFile = $dirPath . uniqid($prefix) . ".csv";
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        do {
            $filterVo->start_record = $startRecord;
            $filterVo->end_record = $limit;
            $objectVos = $serviceObj->$method ($filterVo);
            FileUtil::commonExportCsvFromObjects($hasHeading, $headMapping, $objectVos, $fullPathFile);
            $hasHeading = false;
            $startRecord = $startRecord + $limit;
        } while (count($objectVos) == $limit);
        return $fullPathFile;
    }

    public static function exportCsvCustom($customFileName = "", $hasHeading = true, $headMapping = array(), $filterVo, $serviceObj, $method, $delimiter = ";", $dataProperty = null, &$dataReturn = array(), $enclose = '"')
    {
        $limit = 200;
        $startRecord = 0;
        $dirPath = AppUtil::defaultIfEmpty(ApplicationConfig::get("export.tmp.path"));
        $fullPathFile = $dirPath . $customFileName . ".csv";
        if (!file_exists($dirPath)) {
            mkdir($dirPath, 0755, true);
        }
        do {
            $filterVo->start_record = $startRecord;
            $filterVo->end_record = $limit;
            $objectVos = $serviceObj->$method ($filterVo);
            FileUtil::commonExportCsvFromObjectsCustom($hasHeading, $headMapping, $objectVos, $fullPathFile, $delimiter, $dataProperty, $dataReturn, $enclose);
            $hasHeading = false;
            $startRecord = $startRecord + $limit;
        } while (count($objectVos) == $limit);
        return $fullPathFile;
    }

    private static function commonExportCsvFromObjects($includeHeading = true, $headMapping = array(), $objects, $fullPathFile)
    {
        if (AppUtil::isEmptyString($fullPathFile)) {
            throw new \Exception ("Invalided File Path!");
        }

        if (!is_array($objects)) {
            throw new \Exception ("Input required array!");
        }

        $file = fopen($fullPathFile, "a");

        // detect to write heading
        if ($includeHeading) {
            $headingArray = array();
            foreach ($headMapping as $key => $val) {
                $headingArray [] = $key;
            }
            fputcsv($file, $headingArray);
        }
        foreach ($objects as $object) {
            $valuesArray = array();
            foreach ($headMapping as $key => $val) {
                $valuesArray [] = AppUtil::defaultIfEmpty($object->$val);
            }
            fputcsv($file, $valuesArray);
        }
        fclose($file);
    }

    private static function commonExportCsvFromObjectsCustom($includeHeading = true, $headMapping = array(), $objects, $fullPathFile, $delimiter = ";", $dataProperty = null, &$dataReturn = array(), $enclose = '"')
    {
        if (AppUtil::isEmptyString($fullPathFile)) {
            throw new \Exception ("Invalided File Path!");
        }

        if (!is_array($objects)) {
            throw new \Exception ("Input required array!");
        }

        $file = fopen($fullPathFile, "a");

        // detect to write heading
        if ($includeHeading) {
            $headingArray = array();
            foreach ($headMapping as $key => $val) {
                $headingArray [] = $key;
            }
            fputcsv($file, $headingArray, $delimiter, $enclose);
        }
        foreach ($objects as $object) {
            $valuesArray = array();
            foreach ($headMapping as $key => $val) {
                if (AppUtil::isEmptyString($val)) {
                    $valuesArray [] = "";
                } else {
                    $valuesArray [] = AppUtil::defaultIfEmpty($object->$val);
                }
            }
            fputcsv($file, $valuesArray, $delimiter, $enclose);
            if (!is_null($dataProperty)) {
                $dataReturn [] = $object->$dataProperty;
            }
        }
        fclose($file);
    }

    public static function createFileFromTemplate($data = array(), $outputFilePath, $templatePath, $templateName)
    {
        $template = new Engine ($templatePath);
        $str = $template->render($templateName, $data);
        $dirPath = AppUtil::defaultIfEmpty(ApplicationConfig::get("export.tmp.path"));
        file_put_contents($outputFilePath, $str);
    }

    public static function createDir($dir)
    {
        // $dirPath = "";
        $dirPath = $tok = strtok($dir, "/");
        while ($tok !== false) {
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }
            $tok = strtok("/");
            $dirPath .= "/" . $tok;
        }
    }

    public static function createFile($fileName, $fileContent)
    {
        $f = fopen($fileName, "w+");
        // Now UTF-8 - Add byte order mark
        // fwrite($f, pack("CCC",0xef,0xbb,0xbf));
        fwrite($f, $fileContent);
        fclose($f);

        // $file = fopen($fileName, "w+");
        // fwrite($file, $fileContent);
        // fclose($file);
    }

    public static function appendFile($fileName, $fileContent)
    {
        $f = fopen($fileName, "a+");
        // Now UTF-8 - Add byte order mark
        // fwrite($f, pack("CCC",0xef,0xbb,0xbf));
        fwrite($f, $fileContent);
        fclose($f);

        // $file = fopen($fileName, "w+");
        // fwrite($file, $fileContent);
        // fclose($file);
    }

    public static function readFile($fileName)
    {
        $file = fopen($fileName, "r") or \DatoLogUtil::error('[' . $fileName . '] file not found.');
        // Output one line until end-of-file
        $content = '';
        while (!feof($file)) {
            $content .= fgets($file) . "\n";
        }
        fclose($file);

        return $content;
    }

    public static function deleteFile($fileName)
    {
        global $logger;
        $isDelete = false;
        try {
            $isDelete = unlink($fileName);
        } catch (Exception $e) {
            $logger->error($e);
        }
        return $isDelete;
    }
}

?>