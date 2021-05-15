<?php
use common\helper\DatoImageHelper;
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use core\Lang;
use core\config\ApplicationConfig;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$productsNew = RequestUtil::get ( 'productsNew' );
// var_dump($productsNew);die();
?>
<div class="container" id="containerr">
<div class="content products general-products">
	<h2 class="text-center"><?=Lang::get(" The most popular products")?></h2>
	<div id="products">
	<?php
	foreach ( $productsNew as $product ) {
		$isShow = true;
		if (strtolower ( LocalizationHelper::getCurrentCountryCode () ) != "dk" && ProductHelper::checkProductShowForCountry ( $product->id ) && empty ( SessionUtil::get ( ApplicationConfig::get ( "session.user.login.name" ) ) )) {
			$isShow = false;
		}
		if ($isShow) {
			$imageMo = DatoImageHelper::getImageInfoById ( json_decode ( $product->images ) [0] );
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
					<a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>"> <img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="<?=$product->name?>" width="216" height="269">
					</a>
				</div>
				<div class="product-name"><?= $product->name ?></div>
				<div class="learn-more">
					<a href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>"> <span><?= Lang::get("Find out more") ?>
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
	</div>
</div>
</div>