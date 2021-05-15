<?php
use common\helper\DatoImageHelper;
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$categoryId = RequestUtil::get('categoryId');
$productCategory = RequestUtil::get('productCategory');
$category = $productCategory->categoryHomeExtendVo;
$imageMo = DatoImageHelper::getImageInfoById($category->bgImg);
$products = $productCategory->productHomeExtendArray->getArray();
$o = RequestUtil::get('o');
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("body").attr("class", "_products __simplepage has-submenu");
	});
</script>
<main id="main">
    <div class="container" id="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="content products">
                    <div class="headline">
                        <div class="col-lg-10 col-md-8">
                            <div class="fl products-header-label"><?= Lang::get("Sắp xếp") ?>:</div>
                            <div class="btn-group fl filter-select rel">
                                <button type="button" class="btn btn-default dropdown-toggle products-header-button" data-toggle="dropdown">
                                	<span id="title-orderby">
									<?php
											echo Lang::get("Mới nhất");
									?>
									</span>
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="javascript:getCategoryDetailOrderBy(<?=$categoryId?>,'pa')"><?= Lang::get("Giá (Thấp-Cao)") ?></a>
                                    </li>
                                    <li>
                                        <a href="javascript:getCategoryDetailOrderBy(<?=$categoryId?>,'pd')"><?= Lang::get("Giá (Cao-Thấp)") ?></a>
                                    </li>
                                    <li>
                                        <a href="javascript:getCategoryDetailOrderBy(<?=$categoryId?>,'p')"><?= Lang::get("Phổ biến") ?></a>
                                    </li>
                                    <li>
                                        <a href="javascript:getCategoryDetailOrderBy(<?=$categoryId?>,'n')"><?= Lang::get("Mới Nhất") ?></a>
                                    </li>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
                        <div class="col-lg-2 col-md-4">

                        </div>
                        <div class="clear"></div>
                    </div>
                    <div id="products">
						<?php if (count($products) == 0) {
						} else {
							foreach ($products as $product) {
								$isShow = true;
								if (strtolower(LocalizationHelper::getCurrentCountryCode()) != "dk" && ProductHelper::checkProductShowForCountry($product->id) && empty(SessionUtil::get(ApplicationConfig::get("session.user.login.name")))) {
									$isShow = false;
								}
								if ($isShow) {
									$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images)[0]);
									?>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="product">
                                            <!--<div class="add-to-card">
                                    <a class="top-hover" href="<?/*=ActionUtil::getFullPathAlias("product/detail?id=$product->id",new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name))*/
											?>"></a>
                                    <a class="add-basket" href="#" onclick="shoppingCartUpdate(<?/*=$product->id*/
											?>, 1);return false;">ADD TO
                                        BASKET
                                    </a>
                                    <a class="find-out" href="<?/*=ActionUtil::getFullPathAlias("product/detail?id=$product->id",new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name))*/
											?>">
                                        Find out more
                                    </a>
                                    <a class="bottom-hover" href="<?/*=ActionUtil::getFullPathAlias("product/detail?id=$product->id",new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name))*/
											?>"></a>
                                </div>-->
                                            <div class="image_center">
                                                <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                    <img src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt="" width="204" height="269">
                                                </a>
                                            </div>
                                            <div class="product-name"><?= $product->name ?></div>
                                            <div class="learn-more">
                                                <a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                                                    <span><?= Lang::get("Xem thêm") ?>
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
                                                    <a href="#" onclick="shoppingCartUpdate(<?= $product->id ?>, 1);return false;"><?= Lang::get("Add to basket") ?></a>
                                                </div>
												<?php
											}
											?>
                                        </div>
                                    </div>
									<?php
								}
							}
						} ?>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript">
	function getCategoryDetailOrderBy(categoryId,orderby){
		switch (orderby) {
			case 'pa':
				$("#title-orderby").html('<?=Lang::get("Giá (Thấp-Cao)")?>');
				break;
			case "pd":
				$("#title-orderby").html('<?=Lang::get("Giá (Cao-Thấp)")?>');
				break;
			case 'p':
				$("#title-orderby").html('<?=Lang::get("Popular")?>');
				break;
			case "n":
				$("#title-orderby").html('<?=Lang::get("Mới nhất")?>');
				break;
			default:
                $("#title-orderby").html('<?=Lang::get("Mới nhất")?>');
				break;
		}
		
		var data = "categoryId="+categoryId+"&o=" + orderby;
		simpleAjaxPost(
			guid(),
			"<?=ActionUtil::getFullPathAlias("category/detail/orderby?rtype=json")?>",
			data,
			getCategoryDetailOrderBySuccess,
			getCategoryDetailOrderByErrors,
			getCategoryDetailOrderByErrors
		);
	}
	function getCategoryDetailOrderBySuccess(res){
		$("#products").html(res.content);
	}
	function getCategoryDetailOrderByErrors(res){
		showMessage(res.errorMessage, 'error');
	}
</script>