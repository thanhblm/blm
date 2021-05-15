<?php

namespace frontend\controllers\site_map;


use common\persistence\base\vo\SeoInfoLangVo;
use common\persistence\extend\vo\CategoryHomeExtendVo;
use common\persistence\extend\vo\ProductExtendVo;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use common\services\layout\PageService;
use common\services\product\ProductHomeService;
use common\services\product\ProductService;
use common\services\seo\SeoInfoLangService;
use core\config\ApplicationConfig;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use frontend\controllers\FrontendController;

class SiteMapController extends FrontendController {
	public $fileName;
	public $filePath;
	private $pageService;

	public function __construct(){
		parent::__construct();
		$this->pageService = new PageService();
	}

	public function index(){

		$content = "<?xml version=\"1.0\" encoding=\"utf-8\"?>
<?xml-stylesheet type=\"text/xsl\" href=\"sitemap-xml.xsl\"?>
<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\" xmlns:xhtml=\"http://www.w3.org/1999/xhtml\" xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\" xsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\">";

		// Write page urls
		//Get list pages from config
		$pagesArr = ApplicationConfig::get("action.alias.list");
		foreach ($pagesArr as $alias => $action) {
			$filter = new SeoInfoLangVo();
			$filter->url = $alias;
			$pageVo = $this->pageService->getPageInfoBySeoUrl($filter);
			if (!empty($pageVo) || $alias == "/") {
				$alias = $alias != "/" ? $alias : "";
				$content .= "<url>
							<loc>" . ActionUtil::getFullPathAlias($alias) . "</loc>";
				foreach ($this->languages as $lang) {
					$content .= "<xhtml:link rel=\"alternate\" hreflang=\"$lang->code\" href=\"" . ActionUtil::getFullPathAlias("$lang->code/" . $alias) . "\" />";
				}
				if ($alias != "") {
					$content .= "<lastmod>" . date("c", strtotime($pageVo->mdDate)) . "</lastmod>";
				} else {
					$content .= "<lastmod>" . date("c", time()) . "</lastmod>";
				}
				$content .= "<changefreq>daily</changefreq>
							<priority>0.3</priority>
						</url>";
			}
		}

		//Write category urls
		$productSv = new ProductHomeService();
		$categoryVo = new CategoryHomeExtendVo();
		$categoryVo->languageCode = "en";
		$categoryVo->status = 'active';
		$categoryVo->order_by = 'orderNo asc';
		$categoriesList = $productSv->getCategoryHomeByFilter($categoryVo);
		foreach ($categoriesList as $cat) {
			$content .= "<url>
							<loc>" . str_replace("/en/", "/", ActionUtil::getFullPathAlias("category/detail?categoryId=" . $cat->id, new CategoryUrlFriendly("", $cat->id, $cat->seoUrl, $cat->name))) . "</loc>";
			foreach ($this->languages as $lang) {
				$content .= "<xhtml:link rel=\"alternate\" hreflang=\"$lang->code\" href=\"" . ActionUtil::getFullPathAlias("category/detail?categoryId=" . $cat->id, new CategoryUrlFriendly($lang->code, $cat->id, $cat->seoUrl, $cat->name)) . "\" />";
			}
			$content .= "<lastmod>" . date("c", strtotime($cat->mdDate)) . "</lastmod>
							<changefreq>weekly</changefreq>
							<priority>0.6</priority>
						</url>";
		}

		//Write products urls
		$productSv = new ProductService();
		$productVo = new ProductExtendVo();
		$seoInfoSv = new SeoInfoLangService();
		$productVo->status = 'active';
		$productsList = $productSv->getProductByFilter($productVo);
		foreach ($productsList as $product) {
			$seoInfoVo = new SeoInfoLangVo();
			$seoInfoVo->itemId = $product->id;
			$seoInfoVo->languageCode = "en";
			$seoInfoVo = $seoInfoSv->getSeoInfoLangByProduct($seoInfoVo);
			$content .= "<url>
							<loc>" . str_replace("/en/", "/", ActionUtil::getFullPathAlias("category/detail?categoryId=" . $cat->id, new ProductUrlFriendly("", $product->id, $seoInfoVo->url, $product->name))) . "</loc>";
			foreach ($this->languages as $lang) {
				$content .= "<xhtml:link rel=\"alternate\" hreflang=\"$lang->code\" href=\"" . ActionUtil::getFullPathAlias("category/detail?categoryId=" . $cat->id, new ProductUrlFriendly($lang->code, $product->id, $seoInfoVo->url, $product->name)) . "\" />
				";
			}
			$content .= "<lastmod>" . date("c", strtotime($product->mdDate)) . "</lastmod>
							<changefreq>weekly</changefreq>
							<priority>0.6</priority>
						</url>
						";
		}
		$content .= "</urlset>";
		try {
			$sitemapPath = AppUtil::defaultIfEmpty(ApplicationConfig::get("sitemap.path"));
			$this->fileName = "sitemap.xml";
			$this->filePath = ROOT . DS . $this->fileName;
			$file = fopen($this->filePath, "w+");
			fwrite($file, $content);
			fclose($file);
			echo "Generated sitemap successfully!";
		} catch (Exception $e) {
			throw $e;
		}
	}

}