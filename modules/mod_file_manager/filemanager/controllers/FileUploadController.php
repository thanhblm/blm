<?php

namespace filemanager\controllers;

use core\Controller;
use core\utils\AppUtil;
use core\utils\FileUploadUtil;
use core\utils\RequestUtil;
use filemanager\model\FileInfoMo;
use filemanager\persistence\base\vo\ImageVo;
use filemanager\services\filemanager\ImageService;
use filemanager\utils\FileManagerHelper;

class FileUploadController extends Controller{
	public $field_id;
	public $pid;
	public $fileFieldName;
	public $ckid;
	public $fileIds;
	public $folderName;
	public $subFolders;

	public function __construct(){
		parent::__construct();
	}

	public function main(){
		$imageService = new ImageService ();
		$this->pid = AppUtil::isEmptyString($this->pid) ? "default" : $this->pid;
		$this->pid = FileManagerHelper::isPidExisted($this->pid) ? $this->pid : "";
		$cfgs = FileManagerHelper::getProfileCfg($this->pid);
		$rootPath = FileManagerHelper::getRealpath($cfgs, "root");
        $fileList = array();
		$missingProcess = true;
		while ($missingProcess) {
			$missingProcess = false;
			$imageVo = new ImageVo ();
			$imageVo->profile = $this->pid;
			$imageVos = $imageService->selectByPid($imageVo);
			foreach ($imageVos as $imageVo) {
				if ($imageVo->status == 'active') {
					if (is_file($rootPath . $imageVo->relativePath . $imageVo->fileName)) {
						$fileInfoMo = new FileInfoMo ();
						$fileInfoMo->fileType = $imageVo->mineType;
						$fileInfoMo->fileName = $imageVo->fileName;
						$fileInfoMo->fileId = $imageVo->id;
						$fileInfoMo->url = FileManagerHelper::getUrl($imageVo);
						$fileInfoMo->thumbUrl = FileManagerHelper::getSmallImageUrl($imageVo);
						$fileInfoMo->relativeUrl = str_replace("\\", "/", $imageVo->relativePath . $imageVo->fileName);
						$fileList [] = $fileInfoMo;
					} else {
						$missingProcess = true;
						$vo = new ImageVo ();
						$vo->id = $imageVo->id;
						$vo->status = 'missing';
						$vo->mdDate = date('Y-m-d H:i:s');
						$vo->mdBy = 0;
						$imageService->updateDynamicByKey($vo);
					}
				}
			}
		}
		$ffs = scandir($cfgs["root.dir"] . $cfgs["dir"]);
		foreach ($ffs as $ff) {
			if($ff == "large" || $ff == "small" || $ff == "medium"){
				continue;
			}
			if (strpos($ff, '.') !== false) {
				continue;
			}
			if (is_dir($cfgs["root.dir"] . $cfgs["dir"] . $ff)) {
				$this->subFolders[] = $ff;
			}
		}
		$this->setAttribute("subFolders", $this->subFolders);
		$this->setAttribute("fileList", $fileList);
		console.log($fileList);
		return "success";
	}

	public function progress(){
		$this->pid = AppUtil::isEmptyString($this->pid) ? "default" : $this->pid;
		$imageService = new ImageService ();
		$cfgs = FileManagerHelper::getProfileCfg($this->pid);

		if (empty ($this->fileFieldName)) {
			$this->fileFieldName = "myfile";
		}
		if (!isset ($_FILES [$this->fileFieldName])) {
			return "success";
		}

		$errors = $_FILES [$this->fileFieldName] ['error'];
		$types = $_FILES [$this->fileFieldName] ['type'];
		$names = $_FILES [$this->fileFieldName] ['name'];
		$sizes = $_FILES [$this->fileFieldName] ['size'];
		$tmps = $_FILES [$this->fileFieldName] ['tmp_name'];
		$imageTypes = array();
		foreach ($errors as $error) {
			if ($error != 0) {
				$this->addFieldError("upload.error", FileUploadUtil::getErrorDescription($error));
			}
		}
		if ($this->hasErrors()) {
			return "success";
		}
		for ($i = 0; $i < count($names); $i++) {
			$fileInfo = FileUploadUtil::prepareFileInfo($names [$i], $tmps [$i]);
			$newFileName = $fileInfo ['filename'] . $fileInfo ['extension'];
			if ($cfgs ['filename.random']) {
				$newFileName = uniqid() . $fileInfo ['extension'];
			}

			$imageVo = new ImageVo ();
			$imageVo->fileName = $newFileName;
			$imageVo->profile = $this->pid;
			$imageVos = $imageService->selectByFilter($imageVo);
			// detect to upload image if missing
			$oldImageVo = null;
			$isUpload = false;
			if (count($imageVos) > 0) {
				if ($imageVos [0]->status == 'missing') {
					$isUpload = true;
					$oldImageVo = $imageVos [0];
				} else {
					$isUpload = false;
				}
			} else {
				$isUpload = true;
			}
			$isImage = FileUploadUtil::isImage($tmps [$i]);
			if ($isUpload) {
				$imageVo = new ImageVo ();
				$imageVo->fileName = $newFileName;
				$imageVo->mineType = $types [$i];
				$imageVo->profile = $this->pid;
				$imageVo->relativePath = FileManagerHelper::getRelativepath($cfgs, "");
				if ($isImage) {
					$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath($cfgs, "small");
				} else {
					$imageVo->relativeSmallPath = FileManagerHelper::getRelativepath($cfgs, "small");
				}
				$imageVo->relativeMediumPath = FileManagerHelper::getRelativepath($cfgs, "medium");
				$imageVo->relativeLargePath = FileManagerHelper::getRelativepath($cfgs, "large");

				$sourceFile = FileManagerHelper::getRealpath($cfgs) . $newFileName;
				FileUploadUtil::moveFile($tmps [$i], $sourceFile);
				if ($isImage) {
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "small") . $newFileName, FileManagerHelper::getWidth($cfgs, "small"));
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "medium") . $newFileName, FileManagerHelper::getWidth($cfgs, "medium"));
					FileUploadUtil::resizeImage($sourceFile, FileManagerHelper::getRealpath($cfgs, "large") . $newFileName, FileManagerHelper::getWidth($cfgs, "large"));
				}
				if (!isset ($oldImageVo)) {
					$imageVo->crDate = date('Y-m-d H:i:s');
					$imageVo->mdDate = date('Y-m-d H:i:s');
					$imageVo->crBy = 0;
					$imageVo->mdBy = 0;
					$imageVo->status = 'active';
					$imageService->createImage($imageVo);
				} else {
					$imageVo->id = $oldImageVo->id;
					$imageVo->mdDate = date('Y-m-d H:i:s');
					$imageVo->mdBy = 0;
					$imageVo->status = 'active';
					$imageService->updateDynamicByKey($imageVo);
				}
			} else {
				\DatoLogUtil::error($newFileName . " is existed in \"" . $this->pid . "\"");
				$this->addFieldError("upload.error", $newFileName . " is existed in \"" . $this->pid . "\"");
			}
		}
		return "success";
	}

	public function image(){
		$imageSize = is_null(RequestUtil::get("imageSize")) ? "" : RequestUtil::get("imageSize");
		$imageName = RequestUtil::get("imageName");
		$imageId = RequestUtil::get("id");

		if (AppUtil::isEmptyString($imageId)) {
			return null;
		}

		$imageVo = new ImageVo ();
		$imageService = new ImageService ();
		$imageVo->id = $imageId;

		$imageVo = $imageService->selectByKey($imageVo);
		if (is_null($imageVo)) {
			return null;
		}
		$fileName = "";
		switch ($imageSize) {
			case "" :
				$fileName = ROOT . DS . $imageVo->relativePath . $imageVo->fileName;
				break;
			case "small" :
				$fileName = ROOT . DS . $imageVo->relativeSmallPath . $imageVo->fileName;
				break;
			case "medium" :
				$fileName = ROOT . DS . $imageVo->relativeMediumPath . $imageVo->fileName;
				break;
			case "large" :
				$fileName = ROOT . DS . $imageVo->relativeLargePath . $imageVo->fileName;
				break;
			default:
				$fileName = ROOT . DS . $imageVo->relativePath . $imageVo->fileName;
				break;
		}
		if (file_exists($fileName)) {
			header('Content-Type:' . $imageVo->mineType);
			readfile($fileName);
		}
		return null;
	}

	public function test(){
		return "success";
	}

	public function delete(){
		$imageIds = $this->fileIds;
		foreach ($imageIds as $imageId) {
			$imageVo = new ImageVo ();
			$imageService = new ImageService ();
			$imageVo->id = $imageId;

			$imageVo = $imageService->selectByKey($imageVo);
			if (is_null($imageVo)) {
				continue;
			}
			$fileDelete = ROOT . DS . $imageVo->relativePath . $imageVo->fileName;;
			$fileSmall = ROOT . DS . $imageVo->relativeSmallPath . $imageVo->fileName;;
			$fileMedium = ROOT . DS . $imageVo->relativeMediumPath . $imageVo->fileName;;
			$fileLarge = ROOT . DS . $imageVo->relativeLargePath . $imageVo->fileName;;
			if (!unlink($fileDelete)) {
				continue;
			}
			if (!unlink($fileSmall)) {
				continue;
			}
			if (!unlink($fileMedium)) {
				continue;
			}
			if (!unlink($fileLarge)) {
				continue;
			}
		}
		$this->addActionMessage("The images is delete successfully");
		return "success";
	}

	public function addFolder(){
		$this->pid = AppUtil::isEmptyString($this->pid) ? "default" : $this->pid;
		$this->pid = FileManagerHelper::isPidExisted($this->pid) ? $this->pid : "";
		$cfgs = FileManagerHelper::getProfileCfg($this->pid);
		$rootPath = FileManagerHelper::getRealpath($cfgs, "");
		$folderPatch = $rootPath . $this->folderName;
		if (!file_exists($folderPatch)) {
			mkdir($folderPatch, 0777, true);
		}
		$this->addActionMessage("The folder has create successfully");
		return "success";
	}

}