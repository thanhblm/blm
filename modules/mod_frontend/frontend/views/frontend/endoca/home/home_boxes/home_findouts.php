<?php
use \core\utils\AppUtil;
use core\utils\RequestUtil;
use common\helper\DatoImageHelper;
use core\utils\ActionUtil;
use common\rule\url\friendly\ProductUrlFriendly;
use frontend\controllers\ControllerHelper;
use core\Lang;

$productFeatureds = RequestUtil::get('productFeatureds');
?>
<div id="find-out" class="white find-out-block featured-products">
    <div class="container">
        <div class="row"><h2 class="text-center"><?=Lang::get(" Featured Product")?></h2>
            <div class="bestsellers" data-jcarousel="true">
				<?php foreach ($productFeatureds as $product) {
					$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images)[0]);
					?>
                    <div>
                        <a class="" href="<?= ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name)) ?>">
                            <div class="slick-inside categorySlideLink">
                                <div class="title" style="height: 75px;">
									<?= $product->name ?>
                                </div>
                                <img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" alt="CBD Oil" title=" CBD Oil " width="125" height="150">
                                <div class="">
                                    <div class="intro_category">
                                        <div class="link"><?= Lang::get("Buy from") ?> <?= ControllerHelper::showProductPrice($product->price) ?>
                                            <div class="arrow-wrap">
                                                <img src="<?= AppUtil::resource_url("layouts/endoca.com/images/arrow3.png") ?>" alt="CBD Oil" title=" CBD Oil " width="40" height="17">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
				<?php } ?>

            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".bestsellers").slick({
			infinite: !0,
			slidesToShow: 4,
			slidesToScroll: 4,
			centerMode: !1,
			centerPadding: "0px",
			prevArrow: '<a href="javascript: void(0)" class="slick-prev"><span class="sprite carousel_prev"></span></a>',
			nextArrow: '<a href="javascript: void(0)" class="slick-next"><span class="sprite carousel_next"></span></a>',
			responsive: [{
				breakpoint: 1280,
				settings: {
					arrows: !0,
					centerMode: !1,
					centerPadding: "0px",
					slidesToShow: 3,
					slidesToScroll: 3
				}
			}, {
				breakpoint: 1024,
				settings: {
					arrows: !0,
					centerMode: !1,
					centerPadding: "0px",
					slidesToShow: 3,
					slidesToScroll: 3
				}
			}, {
				breakpoint: 768,
				settings: {
					arrows: !0,
					centerMode: !1,
					centerPadding: "0px",
					slidesToShow: 2,
					slidesToScroll: 2
				}
			}, {
				breakpoint: 560,
				settings: {
					arrows: !0,
					centerMode: !1,
					centerPadding: "0px",
					slidesToShow: 1,
					slidesToScroll: 1
				}
			}]
		});
	});
</script>