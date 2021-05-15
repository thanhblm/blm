<?php
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use core\config\ApplicationConfig;
use core\config\ModuleConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use common\helper\DatoImageHelper;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;
use common\template\extend\ModalTemplate;

$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule())['VIEW_PATH'] . DS . ApplicationConfig::get("template.name") . DS;
$productCategories = RequestUtil::get('productCategories');
$categories = RequestUtil::get('categories');
$otherCats = RequestUtil::get("categoryOther");
$o = RequestUtil::get('o');
$countOrderProduct = 0;
if (!is_null(SessionUtil::get("listOrderProduct"))) {
	$countOrderProduct = count(SessionUtil::get("listOrderProduct")->getArray());
}
?>
<script type="text/javascript">
	$("body").attr("class", "_products __simplepage has-submenu");
</script>
<main id="main">
    <article class="box _1of1 wide product-categories">
        <div class="float">
			<?php if (count($categories) > 0) {
				$categoryCount = count($categories);
				$categoryWidth = ROUND(100 / $categoryCount, 0, PHP_ROUND_HALF_DOWN);
				foreach ($categories as $category) {
					$imageMo = DatoImageHelper::getImageInfoById($category->smallIcon);
					?>
                    <a href="#c<?= $category->id ?>" class="scroll" style="width: <?= $categoryWidth ?>%">
                        <img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>" alt="<?=$category->name?>" width="40" height="40">
                        <span><?= $category->name ?></span>
                    </a>
					<?php
				}
			} ?>
        </div>
        <div id="cat-float-basket">
            <div class="load-tpc on-small-ex">
                <div class="top-card-container">
                    <a href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>" class="top-card">
                        <span class="cart-count"><?= $countOrderProduct ?></span><span class="icon small-card"></span>
                    </a>
                    <div class="top-card-basket">
                        <div class="load-tpcc">
                            <div class="col-xs-12 fw_sidebar-container" style="margin-top:8px;">
                                <div id="fw_sidebar">
                                    <div class="content rel">
                                        <div class="headline">
                                            <div class="fz18">
                                                <span class="fr icon basket"></span><?= Lang::get("Shopping") ?>
                                                <strong><?= Lang::get("Basket") ?></strong>
                                            </div>
                                        </div>
                                        <div class="shopping" id="fw_sidecart_contents">
											<?php include $viewPath . "cart" . DS . "add_to_cart_view_data.php"; ?>
                                        </div>
                                        <div class="clear"></div>
                                        <div class="wave "></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
    <div class="container" id="containerr">
        <div class="row">
            <div class="col-xs-12">
                <div class="headline">
                    <div class="col-lg-7 col-md-7">
                    	<a style="font-size: 2em;text-decoration: underline;" href="#anchor-footer">
                            <strong><?= Lang::get("Lý do bạn chọn Sbirds?") ?></strong></a>
                    </div>
                    <div class="col-lg-5 col-md-5" style="margin-top: 12px">
                        <div class="btn-group fr filter-select rel">
                            <button type="button" class="btn btn-default dropdown-toggle products-header-button" data-toggle="dropdown">
	                            <span id="title-orderby">
								<?php
								echo Lang::get("Giá (Thấp-Cao)");
								?>
								</span>
	                            <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="javascript:getProductsOrderBy('ca')"><?= Lang::get("Danh mục") ?></a>
                                </li>
                                <li>
                                    <a href="javascript:getProductsOrderBy('pa')"><?= Lang::get("Giá (Thấp-Cao)") ?></a>
                                </li>
                                <li>
                                    <a href="javascript:getProductsOrderBy('pd')"><?= Lang::get("Giá (Cao-Thấp)") ?></a>
                                </li>
                            </ul>
                        </div>
                        <div class="fr products-header-label"><?= Lang::get("Sắp xếp:") ?></div>
                        <div class="clear"></div>
                    </div>
                    <div class="clear"></div>
                </div>
            </div>
            <div class="col-xs-12">
                <div class="content products general-products">
                    <div id="products">
						<?php
						foreach ($productCategories->getArray() as $productCategory) {
							$category = $productCategory->categoryHomeExtendVo;
							$imageMo = DatoImageHelper::getImageInfoById($category->bigIcon);
							?>
                            <div id="c<?= $category->id ?>" class="general_product_category">
                                <img src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt="<?=$category->name?>" width="60" height="60">
                                <div class="title">
                                    <a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?>
                                        <span class="title-arrow"></span></a>
                                    <span class="description"><?= $category->introduction ?></span>
                                </div>
                                <div class="cb"></div>
                            </div>
							<?php
							foreach ($productCategory->productHomeExtendArray->getArray() as $product) {
								$isShow = true;
								if (strtolower(LocalizationHelper::getCurrentCountryCode()) != "dk" && ProductHelper::checkProductShowForCountry($product->id) && empty(SessionUtil::get(ApplicationConfig::get("session.user.login.name")))) {
									$isShow = false;
								}
								if ($isShow) {
									$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images)[0]);
									?>
                                    <div class="col-md-6 col-lg-3">
                                        <div class="product ui-draggable ui-draggable-handle">
                                            <!--<div class="add-to-card">
                                    <a class="top-hover" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>"></a>
                                    <a class="add-basket" href="#" onclick="shoppingCartUpdate(<?/*= $product->id */ ?>, 1);return false;"><?/*= Lang::get("Add to basket") */ ?>
                                    </a>
                                    <a class="find-out" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>">
										<?/*= Lang::get("Find out more") */ ?>
                                    </a>
                                    <a class="bottom-hover" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>"></a>
                                </div>-->
                                            <div class="image_center">
                                                <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                    <img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="<?=$product->name?>" width="216" height="269">
                                                </a>
                                            </div>
                                            <div class="product-name"><?= $product->name ?></div>
                                            <div class="learn-more">
                                                <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                    <span><?= Lang::get("Find out more") ?>
                                                        <i class="fa fa-play"></i></span>
                                                </a>
                                            </div>
                                            <div class="price">
												<?= ControllerHelper::showProductPrice($product->price) ?>
												<?php
												if ($product->price != $product->basePrice) {
													?>
                                                    <span><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
													<?php
												}
												?>
                                            </div>
											<?php
											if ($product->type != 'seo') {
												?>
                                                <div class="add-to-cart">
                                                    <a href="#" onclick="getDetailProductModal(<?= $product->id ?>);return false;"><?= Lang::get("Add to basket") ?></a>
                                                </div>
												<?php
											}
											?>
                                        </div>
                                    </div>
									<?php
								}
							}
							?>
                            <div class="cb"></div>
							<?php
						}
						?>
                        <div class="general_product_category"></div>
						<?php
						foreach ($otherCats->getArray() as $otherCat) {
							$category = $otherCat->categoryHomeExtendVo;
							?>
                            <a id="c<?= $category->id ?>"></a>
							<?php
							foreach ($otherCat->productHomeExtendArray->getArray() as $product) {
								$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images)[0]);
								?>
                                <div class="col-md-6 col-lg-3">
                                    <div class="product ui-draggable ui-draggable-handle">
                                        <!--<div class="add-to-card">
                                    <a class="top-hover" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>"></a>
                                    <a class="add-basket" href="#" onclick="shoppingCartUpdate(<?/*= $product->id */ ?>, 1);return false;"><?/*= Lang::get("Add to basket") */ ?>
                                    </a>
                                    <a class="find-out" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>">
										<?/*= Lang::get("Find out more") */ ?>
                                    </a>
                                    <a class="bottom-hover" href="<?/*= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) */ ?>"></a>
                                </div>-->
                                        <div class="image_center">
                                            <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                <img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="<?=$product->name?>" width="216" height="269">
                                            </a>
                                        </div>
                                        <div class="product-name"><?= $product->name ?></div>
                                        <div class="learn-more">
                                            <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                <span><?= Lang::get("Find out more") ?>
                                                    <i class="fa fa-play"></i></span>
                                            </a>
                                        </div>
                                        <div class="price">
											<?= ControllerHelper::showProductPrice($product->price) ?>
											<?php
											if ($product->price != $product->basePrice) {
												?>
                                                <span><?= ControllerHelper::showProductPrice($product->basePrice) ?></span>
												<?php
											}
											?>
                                        </div>
                                        <div class="add-to-cart">
                                            <a href="#" onclick="getDetailProductModal(<?= $product->id ?>);return false;"><?= Lang::get("Add to basket") ?></a>
                                        </div>
                                    </div>
                                </div>
								<?php
							}
							?>
							<?php
						}
						?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<?php
$modalTemplate = new ModalTemplate();
$modalTemplate->id = "modalDialog";
$modalTemplate->render();

?>
<style type="text/css">
	#modalDialog{
	    width: 85%;
    	margin: 0 auto;
	}
	#modalDialog .modal-dialog{
		max-width:100%;
		width:100%;
		top:0;
	}
</style>
<script type="text/javascript">
	//	console.log("top: " + $(".float").outerHeight());
	//	$("#cat-float-basket").attr("style", "top: " + $(".float").outerHeight() + "px");
	$('a').click(function(){
		var top = $('body').find($(this).attr('href')).offset().top;
		$('html, body').animate({
			scrollTop: top
		},1000, 'easeOutExpo');

		return false;
	});
	function getProductsOrderBy(orderby){
		switch (orderby) {
			case 'ca':
				$("#title-orderby").html('<?=Lang::get("Category")?>');
				break;
			case 'pa':
				$("#title-orderby").html('<?=Lang::get("Price (Low-High)")?>');
				break;
			case "pd":
				$("#title-orderby").html('<?=Lang::get("Price (High-Low)")?>');
				break;
			default:
                $("#title-orderby").html('<?=Lang::get("Price (High-Low)")?>');
				break;
		}

		var data = "o=" + orderby;
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("category/orderby?rtype=json")?>",
			data,
			getProductsByOrderSuccess,
			getProductsByOrderErrors,
			getProductsByOrderErrors
		);
	}
	function getProductsByOrderSuccess(res){
		$("#products").html(res.content);
	}
	function getProductsByOrderErrors(res){
		showMessage(res.errorMessage, 'error');
	}

	function getDetailProductModal(productId){
		simpleModalUpload(
				"#modalDialog", 
				"", 
				guid(), 
				"<?=ActionUtil::getFullPathAlias("product/detail/dialog") ?>" + "?rtype=json&id=" + productId
				);
	}
</script>