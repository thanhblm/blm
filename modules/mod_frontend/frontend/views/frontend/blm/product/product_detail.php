<?php

use api\controllers\ControllerHelper;
use common\helper\DatoImageHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\CategoryUrlFriendly;
use core\config\FConstants;
use core\config\ModuleConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;

$product = RequestUtil::get("product");
$category = RequestUtil::get("category");
$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) [FConstants::VIEW_PATH];
?>
<div class="banner margin_bottom_150">
	<div class="container">
		<h1 class="title-font title-banner banner-product-detail"><?= $product->seoTitle ?></h1>
		<ul class="breadcrumb des-font">
			<li>
				<a title="<?= $titlePage ?>" href="<?= ActionUtil::getFullPathAlias("/", new AliasUrlFriendly("")) ?>"><?= Lang::get("Trang chủ") ?></a>
			</li>
			<li>
				<a href="<?= ActionUtil::getFullPathAlias("category/list", new AliasUrlFriendly("products")) ?>"><?= Lang::get("Cửa hàng") ?></a>
			</li>
			<li>
				<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
			</li>
			<li class="active"><?= $product->seoTitle ?></li>
		</ul>
	</div>
</div>
<!--  -->
<div class="container product-detail margin_bottom_150">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 margin_bottom_50">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
					<div class="slick-nav-product-detail-vertical">
						<?php
						$listImages = json_decode($product->images);
						foreach ($listImages as $key => $imageId) {
							$imageMo = DatoImageHelper::getImageInfoById($imageId);
							?>
							<div>
								<img src="<?= DatoImageHelper::getSmallImageUrl($imageMo) ?>" class="img-responsive" alt="">
							</div>
							<?php
						}
						?>
					</div>
				</div>
				<div class="col-lg-9 col-md-9 col-sm-9 col-xs-9">
					<div class="slick-product-detail-vertical margin_bottom_20">
						<?php
						$listImages = json_decode($product->images);
						foreach ($listImages as $key => $imageId) {
							$imageMo = DatoImageHelper::getImageInfoById($imageId);
							?>
							<div>
								<img src="<?= DatoImageHelper::getLargeImageUrl($imageMo) ?>" class="img-responsive full-width" alt="">
							</div>
							<?php
						}
						?>
					</div>
				</div>
			</div>

			<!--  -->

		</div>
		<div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 info-product-detail" id="info-product-detail">
			<h1 class="title-font title-product margin_bottom_30"><?= $product->seoTitle ?></h1>
			<p class="product-preview margin_bottom_50">
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<i class="ti-star"></i>
				<span class="relative line-space">__</span>
				<span class="des-font">(02) Reviews</span>
			</p>
			<!-- attribute -->
			<?php
			include 'attribute/product_attribute_data.php';
			?>
			<!-- end attr -->

			<div class="flex margin_bottom_50 border-bot space_bot_50 btn-function">
				<div class="input-number-group">
					<div class="relative input-number-custom">
						<div class="input-group-button absolute down-btn">
							<span class="input-number-decrement ti-angle-down"></span>
						</div>
						<input class="input-number menu-font" type="number" min="0" max="1000" value="1">
						<div class="input-group-button absolute up-btn">
							<span class="input-number-increment ti-angle-up"></span>
						</div>
					</div>
				</div>
				<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
					<input type="hidden" name="id" value=""/>
					<button type="submit" onclick="shoppingCartUpdate(668865, $('#txt_quantity').val(), $(this).data('product-attribute'));return false;" name="add" class="enj-add-to-cart-btn btn-default menu-font uppercase">add to
						cart
					</button>
				</form>
				<a href="#" class="icon-heart"><i class="ti-heart"></i></a>
				<a href="#" class="engoj_btn_quickview icon-quickview" title="quickview">
					<i class="ti-more-alt"></i>
				</a>
			</div>
			<!--  -->
			<div class="info-more">
				<p class="des-font margin_bottom_30 margin_top_50"><span class="menu-font">SKU:</span> N/A</p>
				<p class="margin_bottom_30">
					<span class="menu-font margin_right_10">Categories:</span>
					<a href="#" class="delay03 margin_right_10">Bag,</a>
					<a href="#" class="delay03 margin_right_10">Women,</a>
					<a href="#" class="delay03 margin_right_10">New Arrival</a>
				</p>
				<p class="margin_bottom_30">
					<span class="menu-font margin_right_30">Share:</span>
					<a href="#" class="delay03 margin_right_30"><i class="ti-facebook"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-twitter-alt"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-pinterest"></i></a>
					<a href="#" class="delay03 margin_right_30"><i class="ti-linkedin"></i></a>
				</p>
			</div>
		</div>
	</div>
</div>
<!--  -->

<!--  -->

<!--  -->
<div class="tab-content-detail container margin_bottom_150">
	<div class="border-bot space_bot_100">
		<ul class="nav nav-tabs btn-tab-product-detail margin_bottom_100">
			<li class="active"><a data-toggle="tab" href="#home" class=" menu-font btn-tab relative">Description
					<figure class="line"></figure>
				</a></li>
			<li class="container_60"><a data-toggle="tab" href="#menu1" class=" menu-font btn-tab relative">Shipping &
					returns
					<figure class="line"></figure>
				</a></li>
			<li><a data-toggle="tab" href="#menu2" class=" menu-font btn-tab relative">Customer reviews (0)
					<figure class="line"></figure>
				</a></li>
		</ul>
		<div class="tab-content">
			<div id="home" class="tab-pane fade in active">
				<p class="des-font des-tab">Tote bag from Mansur Gavriel in Saddle. Calf leather. Open compartment.
					Interior side pocket. Top handles. Detachable, adjustable shoulder strap. Goldtone hardware.
					Embossed logo detailing at exterior. Tonal patent coated
					interior. Tote bag from Mansur Gavriel in Saddle. Calf leather. Open compartment. Interior side
					pocket. Top handles. Detachable, adjustable shoulder strap. Goldtone hardware. Embossed logo
					detailing at exterior. Tonal patent
					coated interior.<br><br></p>
				<ul class="space_left_20 des-font des-tab">
					<li>Leather</li>
					<li>Made in Italy</li>
				</ul>
				<h2 class="menu-font btn-tab">Features:</h2>
				<ul class="space_left_20 des-font des-tab">
					<li>Compatible for indoor and outdoor use</li>
					<li>Wide polypropylene shell seat for unrivalled comfort</li>
					<li>Rust-resistant frame</li>
					<li>Durable UV and weather-resistant construction</li>
					<li>Shell seat features water draining recess</li>
					<li>Shell and base are stackable for transport</li>
					<li>Choice of monochrome finishes and colourways</li>
					<li>Designed by Nagi</li>
				</ul>
			</div>
			<div id="menu1" class="tab-pane fade">
				<p class="des-font des-tab">Tote bag from Mansur Gavriel in Saddle. Calf leather. Open compartment.
					Interior side pocket. Top
					handles. Detachable, adjustable shoulder strap. Goldtone hardware. Embossed logo detailing at
					exterior.
					Tonal patent coated interior.<br><br></p>
				<ul class="space_left_20 des-font des-tab">
					<li>Leather</li>
					<li>Made in Italy</li>
				</ul>
			</div>
			<div id="menu2" class="tab-pane fade">
				<div class="row">
					<div class="review margin_bottom_50 col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<h1 class="menu-font title-review">Reviews</h1>
						<p class="des-font content-review">There are no review yet.</p>
					</div>
					<div class="form-review col-lg-6 col-md-6 col-sm-6 col-xs-6">
						<h1 class="menu-font title-form">Be the first to review “Embossed blackpack in brown” </h1>
						<p class="des-font des-review margin_bottom_50">Your email address will not be published.
							Required fields are marked *</p>
						<form>
							<input type="text" name="name" placeholder="First name*" class="margin_bottom_20 des-font">
							<input type="email" name="EMAIL" placeholder="Email*" class="margin_bottom_20 des-font">
							<textarea placeholder="Message*" class="margin_bottom_20 des-font"></textarea>
							<p class="menu-font margin_bottom_20 rating">Your rating
								<i class="ti-star"></i>
								<i class="ti-star"></i>
								<i class="ti-star"></i>
								<i class="ti-star"></i>
								<i class="ti-star"></i>
							</p>
							<button type="submit" class="menu-font uppercase">submit</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- ------------------------------------ -->
</div>
<!--  -->
<div class="container margin_bottom_130 section-bestseller-home1">
	<div class="row">
		<div class="col-md-12">
			<h1 class="title-font margin_bottom_10 title-bestseller">Related products</h1>
			<p class="des-font margin_bottom_50 des-bestseller">I did not even know that there were any better
				conditions to escape to, but I was more than willing
				to take my chances among people fashioned after.</p>
			<div class="slick-bestseller">
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_1.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-new title-font text-center">new</figure>
						<div class="product-icon text-center absolute">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font price-product"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_2.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_3.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-new title-font text-center">new</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_4.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_5.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
				<div class="product">
					<div class="img-product relative">
						<a href="#"><img src="asset/img/product_1.jpg" class="img-responsive" alt=""></a>
						<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
						<div class="product-icon absolute text-center">
							<form method="post" action="/cart/add" enctype="multipart/form-data" class="inline-block icon-addcart">
								<input type="hidden" name="id" value=""/>
								<button type="submit" name="add" class="enj-add-to-cart-btn btn-default">
									<i class="ti-bag"></i></button>
							</form>
							<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
							<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
								<i class="ti-more-alt"></i>
							</a>
						</div>
					</div>
					<div class="info-product text-center">
						<h4 class="des-font capital title-product space_top_20"><a href="#">embossed backpack in
								brown</a></h4>
						<p class="number-font"><span class="price">$123.00</span></p>
					</div>
				</div>
				<!--  -->
			</div>

		</div>
	</div>
</div>
<!--  -->
<div class="newsletter-home3 space_bot_150 space_top_130 BG margin_bottom_120">
	<h1 class="title-font capital title-newsletter text-center">Get Our Latest Update In Your Email</h1>
	<p class="des-font des-newsletter space_bot_60 text-center">Subscribe now to get 15% off on any product</p>
	<form class="form-group des-font flex" method="post" target="_blank">
		<input type="email" name="EMAIL" class="form-control" placeholder="Your email address...">
		<button type="submit" class="menu-font uppercase">subscribe</button>
	</form>
</div>
<!--  -->
