<?php

use common\helper\DatoImageHelper;
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$productCategories = RequestUtil::get('productCategories');
$otherCats = RequestUtil::get("categoryOther");

?>
<?php
foreach ($productCategories->getArray() as $productCategory) {
	$category = $productCategory->categoryHomeExtendVo;
	$imageMo = DatoImageHelper::getImageInfoById($category->bigIcon);
	?>
	<div id="c<?= $category->id ?>" class="general_product_category">
		<img src="<?= DatoImageHelper::getUrl($imageMo) ?>" width="60" height="60">
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
							<img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="" width="216" height="269">
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
						<img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="" width="216" height="269">
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
					<a href="#" onclick="shoppingCartUpdate(<?= $product->id ?>, 1);return false;"><?= Lang::get("Add to basket") ?></a>
				</div>
			</div>
		</div>
		<?php
	}
	?>
	<?php
}
?>
                    