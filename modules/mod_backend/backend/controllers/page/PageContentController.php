<?php 
namespace backend\controllers\page;

use common\helper\LayoutHelper;
use core\PagingController;
use core\config\ModuleConfig;
use core\utils\RouteUtil;
use core\config\ApplicationConfig;
use common\services\seo\SeoInfoLangService;
use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\base\vo\PageVo;
use common\services\layout\PageService;
use common\services\language\LanguageService;
use common\persistence\base\vo\ProductVo;
use common\services\product\ProductService;
use common\persistence\extend\dao\ProductLangExtendDao;
use common\persistence\base\vo\ProductLangVo;
use core\utils\AppUtil;

class PageContentController extends PagingController {
	public $pageId;
	public $languageCode;
	
	public function __construct() {
		parent::__construct ();
	}
	
	public function generateRawContentForm() {
		$pageSv = new PageService();
		$pageVos = $pageSv->selectAll();
		$languageSv = new LanguageService();
		$languageVos = $languageSv->getAllLanguages();
		$this->setAttribute("pageVos", $pageVos);
		$this->setAttribute("languageVos", $languageVos);
		return "success";
	}
	
	public function generateRawContent() {
		$layoutPath = ModuleConfig::getModuleConfig ( "mod_frontend") ['LAYOUT_PATH'];
		RouteUtil::setUri(ApplicationConfig::get("web.context")."/product/detail");
		if (AppUtil::isEmptyString($this->pageId) || AppUtil::isEmptyString($this->languageCode)){
			echo "Error: missing inputs."."<br>";
			return;
		}
		$productSv = new ProductService();
		$productVos = $productSv->getAllProducts();
		$productVo = null;
		$productLangDao = new ProductLangExtendDao();
		$productLangVo = null;
		foreach ($productVos as $productTmpVo){
			//echo $productTmpVo->pageId ."  vs  ". $this->pageId."    ".($productTmpVo->pageId === $this->pageId)."<br>";
			if ($productTmpVo->pageId == $this->pageId){
				$productLangVo = new ProductLangVo();
				$productLangVo->productId = $productTmpVo->id;
				$productLangVo->languageCode = $this->languageCode;
				$productLangVo = $productLangDao->selectByKey($productLangVo);
				$productVo = $productTmpVo;
				break;
			}
		}
		
		$seoInfoLangSv = new SeoInfoLangService();
		$seoInfoLangVo = new SeoInfoLangVo();
		if (is_null($productVo)){
			$seoInfoLangVo->itemId = $this->pageId;
			$seoInfoLangVo->type = 'page';
		}else{
			$seoInfoLangVo->itemId = $productVo->id;
			$seoInfoLangVo->type = 'product';
		}
		
		$seoInfoLangVo->languageCode = $this->languageCode;
		$seoInfoLangVo = $seoInfoLangSv->selectByKey($seoInfoLangVo);
		$pageVo = new PageVo();
		$pageVo->id = $this->pageId;
		
		$pageSv = new PageService();
		$pageVo = $pageSv->selectByKey($pageVo);
		if (is_null($pageVo)){
			echo "Error: page not found."."<br>";
			return;
		}
		$strSeo = "";
		$strSeo .= "<b>-------------------------------------".$pageVo->id.":".$pageVo->name."-------------------------------------</b><br>";
		$strSeo .= "<b>-------------------------------------START SEO INFO-------------------------------------</b><br>";
		if (!is_null($seoInfoLangVo)){
			$strSeo .= "URL:". $seoInfoLangVo->url."<br>";
			$strSeo .= "TITLE:". $seoInfoLangVo->title."<br>";
			$strSeo .= "KEYWORDS:". $seoInfoLangVo->keywords."<br>";
			$strSeo .= "DESCRIPTION:". $seoInfoLangVo->description."<br>";
		}else{
			$strSeo .= "Warning: No SEO information."."<br>";
		}
		$strSeo .= "<b>-------------------------------------END SEO INFO-------------------------------------</b><br>";
		$usingOldContent = false;
		if (!is_null($productLangVo)){
			$usingOldContent = !AppUtil::isEmptyString($productLangVo->composition) || !AppUtil::isEmptyString($productLangVo->description);
		}
		$strReturn = "";
		if (!$usingOldContent){
			$strReturn = LayoutHelper::generatePageNoCacheContent ( $this->pageId, $this->languageCode);
		}else{
			$strReturn .= "<b>Description:</b><br>".$productLangVo->description;
			$strReturn .= "<br><b>Composition:</b><br>".$productLangVo->composition;
			
		}
		$strReturn = strip_tags($strReturn,"<br>,<b>,<img>,<h2>,<h1>,<h3>,<u>,<i>");
		echo $strSeo.$strReturn;
	}
}