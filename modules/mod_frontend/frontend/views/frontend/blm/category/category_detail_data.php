<?php

use common\helper\DatoImageHelper;
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use common\rule\url\friendly\ProductUrlFriendly;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$productCategory = RequestUtil::get('productCategory');
$products = $productCategory->productHomeExtendArray->getArray();
?>
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
