<?php

use common\helper\DatoImageHelper;
use common\helper\LayoutHelper;
use common\helper\LocalizationHelper;
use common\helper\ProductHelper;
use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ProductUrlFriendly;
use core\config\ApplicationConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\SessionUtil;
use frontend\controllers\ControllerHelper;

$product = RequestUtil::get('product');

$relatedProducts = RequestUtil::get('relatedProducts');
$bulkDiscounts = RequestUtil::get('bulkDiscounts');
$attrExtGroupVos = RequestUtil::get('attrExtGroupVos');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $("body").attr("class", "products _product-detail __ has-submenu");
    });
</script>
<div class="wrap product-inner">
	<div class="container">
		<div class="row">
			<input type="hidden" name="product_id" value="82" id="product_id">
			<div class="col-sm-12 gray-bottom-border">
				<div class="col-sm-9" style="margin: 40px 0 20px">
					<h1>
						<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=$product->categoryId", new CategoryUrlFriendly($product->languageCode, $product->categoryId, $product->categorySeoUrl, $product->categoryName)) ?>"><?= $product->categoryName ?></a>
					</h1>
				</div>
				<div class="col-sm-3">
					<a class="fr back-link"
					   href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=$product->categoryId", new CategoryUrlFriendly($product->languageCode, $product->categoryId, $product->categorySeoUrl, $product->categoryName)) ?>">
						<span class="icon back"></span>
						<?= Lang::get("Back to the products page") ?>
					</a>
				</div>
			</div>
			<div style="margin-bottom: 0;" class="col-sm-12">
				<div class="content product-info gray-bottom-border">
					<div class="col-xs-12 col-md-4 col-md-offset-0 prod-photo">
						<div id="product" class="carousel slide" data-ride="carousel">
							<?php
							if (!AppUtil::isEmptyString($product->images)) {
								$productImages = json_decode($product->images);
								?>
								<ol class="carousel-indicators">
									<?php
									for ($i = 0; $i < count($productImages); $i++) {
										?>
										<li data-target="#product"
										    data-slide-to="<?= $i ?>"
											<?= ($i == 0 ? "class='active'" : '') ?>><span
													class="icon slider-bullet"></span></li>
										<?php
									}
									?>
								</ol>
								<div class="carousel-inner">
									<?php
									for ($i = 0; $i < count($productImages); $i++) {
										$imageMo = DatoImageHelper::getImageInfoById($productImages [$i]);
										?>
										<div
											<?= ($i == 0 ? "class='item active'" : "class='item'") ?>>
											<a class="item_image" rel="group"
											   href="<?= DatoImageHelper::getUrl($imageMo) ?>"><img
														src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt=""
														width="314" height="375"></a>
										</div>
										<?php
									}
									?>
								</div>
								<?php
							} else {
								$imageMo = DatoImageHelper::getImageInfoById(-1);
								?>
								<div class="item">
									<a class="item_image" rel="group" href="#"><img
												src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt=""
												width="314" height="375"></a>
								</div>
								<?php
							}
							?>
						</div>
					</div>
					<div
							class="col-xs-10 col-xs-offset-1 col-md-6 col-md-offset-0 prod-info">
						<div class="rating" id="product_rate10">
							<span class="icon star active" onclick="rate_product(10,1)"></span><span
									class="icon star active" onclick="rate_product(10,2)"></span><span
									class="icon star active" onclick="rate_product(10,3)"></span><span
									class="icon star active" onclick="rate_product(10,4)"></span><span
									class="icon star active" onclick="rate_product(10,5)"></span>
							<div class="clear"></div>
						</div>
						<h2><?= $product->name ?></h2>
						<!-- attribute -->
						<?php
						include 'attribute/product_attribute_data.php';
						?>
						<!-- end attr -->

						<?php
						if ($product->isSeo == 'yes') {
							?>
							<div class="Success_block"
							     style="display:block"><?= SettingHelper::getSettingValue("SEO Product Message") ?></div>
							<?php
						} elseif ($product->status == 'inactive') {
							?>
							<div class="Success_block"
							     style="display:block"><?= Lang::get('Sorry, this product is not available at the moment.') ?></div>
							<?php
						} else {
							if ($product->type != 'seo') {
								?>
								<div class="infoblock">
									<div class="col-xs-7">
										<div class="p-block">
											<input type="hidden" name="id"
											       value="82"><label><?= Lang::get("Select Quantity:") ?></label>
											<div class="amount">
												<input type="text" value="1" name="qty" id="txt_quantity">
												<div class="plus arrow">+</div>
												<div class="minus arrow">-</div>
											</div>

											<button type="button" class="button green" data-product-attribute=""
											        onclick="shoppingCartUpdate(<?= $product->id ?>, $('#txt_quantity').val(), $(this).data('product-attribute'));return false;">
												<span class="text-uppercase"><?= Lang::get("Add to basket") ?></span>
											</button>
										</div>
									</div>
									<div class="col-xs-5">
										<div class="shipping-info mgt35">
											<a
													href="<?= ActionUtil::getFullPathAlias("home/shipping/information", new AliasUrlFriendly("shipping-information")) ?>"><span
														class="icon shipping fl"></span>
												<?= Lang::get("Shipping information") ?>
											</a>
										</div>
										<div class="payment-info">
											<a
													href="<?= ActionUtil::getFullPathAlias("home/payment/information", new AliasUrlFriendly("payment-information")) ?>"><span
														class="icon payment fl"></span>
												<?= Lang::get("Payment information") ?>
											</a>
										</div>
									</div>
									<div class="col-xs-12 socials">
										<div class="addthis_toolbox addthis_default_style ">
											<a class="addthis_button_facebook_like"
											   fb:like:layout="button_count"></a>
											<a
													class="addthis_button_tweet"></a>
											<a
													class="addthis_button_pinterest_pinit"
													pi:pinit:layout="horizontal"></a>
											<a
													class="addthis_counter addthis_pill_style"></a>
										</div>
										<script type="text/javascript">var addthis_config = {"data_track_addressbar": false};</script>
										<script type="text/javascript"
										        src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-4e71f99b0fad3374"></script>
									</div>
									<div class="clear"></div>

								</div>
								<?php
							} else {
								?>
								<div class="Success_block"
								     style="display:block"><?= SettingHelper::getSettingValue('SEO Product Notice') ?></div>
								<?php
							}
						} ?>
					</div>
					<div class="col-xs-10 col-xs-offset-1 col-md-2 col-md-offset-0">
						<ul class="col-xs-12 related-products">
							<li class="header"><span><?= Lang::get("Related products") ?></span></li>
							<?php
							foreach ($relatedProducts as $rProduct) {
								$isShow = true;
								if (strtolower(LocalizationHelper::getCurrentCountryCode()) != "dk" && ProductHelper::checkProductShowForCountry($product->id) && empty(SessionUtil::get(ApplicationConfig::get("session.user.login.name")))) {
									$isShow = false;
								}
								if ($isShow) {
									$images = json_decode($rProduct->images);
									$imageMo = DatoImageHelper::getImageInfoById($images [0]);
									?>
									<li>
										<a
												href="<?= ActionUtil::getFullPathAlias("product/detail?id=$rProduct->id", new ProductUrlFriendly($rProduct->languageCode, $rProduct->id, $rProduct->seoUrl, $rProduct->name)) ?>">
											<img src="<?= DatoImageHelper::getUrl($imageMo) ?>" alt=""
											     width="73" height="96"><span
													class="title"><?= $rProduct->name ?></span><span
													class="price"><?= ControllerHelper::showProductPrice($rProduct->price) ?></span>
										</a>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
					<div class="cart_error"
					     id="cart_error_product"><?= Lang::get("Sorry, this product is not available at the moment") ?>
					</div>
					<div class="clear mgb50"></div>
					<div class="clear"></div>
					<div class="clear"></div>
					<?php
					$usingOldContent = !AppUtil::isEmptyString($product->composition) || !AppUtil::isEmptyString($product->description);
					if (empty($product->pageId)) {
						$usingOldContent = true;
					}

					if ($usingOldContent) {
						?>
						<div class="tabs-container">
							<ul class="nav nav-tabs">
								<?php if (!AppUtil::isEmptyString($product->composition)): ?>
									<li class="active">
										<a href="#composition"
										   data-toggle="tab"><?php echo Lang::get("Composition") ?></a>
									</li>
								<?php endif ?>
								<?php if (!AppUtil::isEmptyString($product->description)): ?>
									<li <?php if (AppUtil::isEmptyString($product->composition)) echo "class='active'"; ?>>
										<a href="#description"
										   data-toggle="tab"><?php echo Lang::get("Information") ?></a>
									</li>
								<?php endif ?>
							</ul>
							<div class="tab-content">
								<?php if (!AppUtil::isEmptyString($product->composition)): ?>
									<div class="tab-pane active" id="composition">
										<?= $product->composition ?>
									</div>
								<?php endif ?>
								<?php if (!AppUtil::isEmptyString($product->description)): ?>
									<div class="tab-pane <?php if (AppUtil::isEmptyString($product->composition)) echo "active"; ?>"
									     id="description">
										<?= $product->description ?>
									</div>
								<?php endif ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="product-desc-content"
     data-pageid="<?= $product->pageId ?>">
	<?php
	if (!$usingOldContent) {
		echo LayoutHelper::getPageContent($product->pageId, RequestUtil::get("languageCode"));
	}
	?>
</div>
<?php
if (!$usingOldContent) {
	?>
	<div class="green product-buy" style="margin-top: 150px; background-color: #76a033; color: #fff">
		<div class="container">
			<div class="container-fluid">
				<div class="row">
					<div class="box col-md-3 col-xs-12 product-buy">
						<div class="thumb">
							<?php
							$imageMo = DatoImageHelper::getImageInfoById($productImages [0]);
							?>
							<img
									src="<?= DatoImageHelper::getLargeImageUrl($imageMo) ?>" alt=""
									width="262" height="340">
						</div>
					</div>
					<div class="box col-md-6 col-xs-12 product-buy">
						<h2><?= $product->name ?></h2>
						<h3><?= Lang::get("Pure and natural") ?></h3>
					</div>
					<div class="box col-md-3 col-xs-12 product-buy">
						<?php
						if ($product->status != 'inactive') {
							?>
							<a href="#"
							   onclick="shoppingCartUpdate(<?= $product->id ?>, 1, $('#productAttribute').val());return false;"
							   class="button"><span><?= Lang::get("Add to Basket") ?></span></a>
							<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript">

        var allVideos = $('iframe[src*="//player.vimeo.com"], iframe[src*="//www.youtube.com"], object, embed'),
            fluidEl = $("body");
        $(window).resize(function () {
            var newWidth = fluidEl.width() - 30;
            allVideos.each(function () {

                var el = $(this);
                el.width(newWidth)
                    .height(newWidth * el.attr('data-aspectRatio'));
            });
        });
        allVideos.each(function () {
            var dataAspectRatio = this.height / this.width;
            // Check whether data-aspectRatio is valid before proceeding
            if (!isNaN(dataAspectRatio)) {
                $(this)
                // jQuery .data does not work on object/embed elements
                    .attr('data-aspectRatio', dataAspectRatio)
                    .removeAttr('height')
                    .removeAttr('width');
                $(window).resize();
            }
        });
	</script>
	<?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        var catURL = "<?= ActionUtil::getFullPathAlias("category/detail?categoryId=$product->categoryId", new CategoryUrlFriendly($product->languageCode, $product->categoryId, $product->categorySeoUrl, $product->categoryName)) ?>";
        var selector = $('ul.navbar-nav a[href="' + catURL + '"]');
        var li = selector.parents('li:last');

        li.siblings().attr("class", "");
        li.children("a").append("<span class=\"hover-arrow\"></span>");
        li.addClass('active open');
        if (selector.closest("li").children("div").length <= 0) {
            selector.closest("li").siblings().attr("class", "");
            selector.closest("li").attr("class", "active");
        }
    });
</script>