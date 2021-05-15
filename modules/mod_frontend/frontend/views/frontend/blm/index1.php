<?php

use api\controllers\ControllerHelper;
use common\helper\DatoImageHelper;
use common\rule\url\friendly\ProductUrlFriendly;
use common\template\extend\Button;
use common\template\extend\TextInput;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;
use core\utils\AppUtil;
$slides = RequestUtil::get("slides");
$productsNew = RequestUtil::get("productsNew");
$productFeatureds = RequestUtil::get("productFeatureds");
?>
<div class="slider-home2 container-fluid">
	<?php
	foreach ($slides as $key => $slide) {
		$imageMo = DatoImageHelper::getImageInfoById($slide->image);
		?>
		<div class="row">
			<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5">
				<div class="text-slider-home2">
					<p class="number-font uppercase number-year text-right delay2">2020</p>
					<p class="number-font uppercase text-new relative text-right">
						<img src="<?=AppUtil::resource_url("layouts/sbirds/asset/img/+slider-home2.png")?>" class="img-responsive absolute delay1" alt="">
						<span class="delay2">new</span>
					</p>
					<p class="menu-child-font uppercase text-collection text-left delay1_5">collection
						<span class="des-font">+</span></p>
				</div>
			</div>
			<div class="col-lg-7 col-md-7 col-sm-7 col-xs-7 relative">
				<div class="info-slider-home2 absolute">
					<div class="flex">
						<p class="number-font number-dot delay1_5">
							<?= "0" . ($key + 1) ?>
							<img src="<?=AppUtil::resource_url("layouts/sbirds/asset/img/line-slider-home2.jpg")?>" class="img-responsive delay1_5 hidden-xs" alt="">
						</p>
					</div>
					<h1 class="title-font capital title-slider-home2 delay1_5"><?= $slide->title ?></h1>
				</div>
				<a href="<?= $slide->url ?>"><img src="<?= DatoImageHelper::getUrl($imageMo) ?>" class="img-responsive img-slider-main delay1_5" alt=""></a>
			</div>
		</div>

		<?php
	}
	?>
</div>
<!--  -->
<div class="container margin_bottom_130 section-bestseller-home1 space_top_140">
	<div class="row">
		<div class="col-md-12">
			<h1 class="title-font margin_bottom_10 title-bestseller"><?= Lang::get("Sản phẩm mới") ?></h1>
			<p class="des-font margin_bottom_50 des-bestseller"><?= Lang::get("Việc tung sản phẩm mới trong ngành thời trang là càng sớm càng tốt (tất nhiên nó sẽ phù hợp với tính mùa vụ)") ?></p>
			<div class="slick-bestseller">
				<?php
				foreach ($productsNew as $product) {
					$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images) [0]);
					$url = ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name));
					?>
					<div class="product">
						<div class="img-product relative">
							<a href="<?= $url ?>"><img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" class="img-responsive" alt="<?= $product->name ?>"></a>
							<figure class="absolute uppercase label-new title-font text-center"><?= Lang::get("Mới") ?></figure>
							<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
							<div class="product-icon text-center absolute">
								<a href="#" onclick="getDetailProductModal(<?= $product->id ?>);return false;" class="icon-addcart inline-block enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></a>
								<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
								<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
									<i class="ti-more-alt"></i>
								</a>
							</div>
						</div>
						<div class="info-product text-center">
							<div class="info-product text-center">
								<h4 class="des-font capital title-product space_top_20">
									<a href="<?= $url ?>" title="<?= $product->seoTitle ?>"><?= $product->seoTitle ?></a>
								</h4>
								<p class="number-font price-product">
									<span class="price"><?= ControllerHelper::showProductPrice($product->price) ?></span>
								</p>
								<p class="des-font des-product"><?= $product->seoDescription ?></p>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</div>
		</div>
	</div>
	<!--  -->
	<div class="testimonial">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h1 class="title-font capital title-testi"><?= Lang::get("Khách hàng đánh giá Sbirds") ?></h1>
					<p class="des-font des-testi"><?= Lang::get("Tôi thậm chí không biết rằng có bất kỳ điều kiện tốt hơn để trốn thoát, nhưng tôi đã sẵn sàng hơn
nắm lấy cơ hội của tôi trong số những người thời trang sau.") ?></p>
				</div>
				<div class="col-md-12">
					<div class="slider-comment">
						<div class="content-comment relative">
							<div class="number-font absolute stt-comment">#01</div>
							<p class="menu-font des-comment space_bot_30">“Quisque condimentum ipsum at velit hendrerit
								venenatis. Donec luctus metus enim, nunced. Sed sit
								amet nisl id purus aliquet cursus et neque vel sodales
								ligula”</p>
							<span class="number-font uppercase author-comment">iryna petrunco </span><span class="des-font capital model">/ model</span>
						</div>
						<!--  -->
						<div class="content-comment relative">
							<div class="number-font absolute stt-comment">#02</div>
							<p class="menu-font des-comment space_bot_30">“Quisque condimentum ipsum at velit hendrerit
								venenatis. Donec luctus metus enim, nunced. Sed sit
								amet nisl id purus aliquet cursus et neque vel sodales
								ligula”</p>
							<span class="number-font uppercase author-comment">iryna petrunco </span><span class="des-font capital model">/ model</span>
						</div>
						<!--  -->
						<div class="content-comment relative">
							<div class="number-font absolute stt-comment">#03</div>
							<p class="menu-font des-comment space_bot_30">“Quisque condimentum ipsum at velit hendrerit
								venenatis. Donec luctus metus enim, nunced. Sed sit
								amet nisl id purus aliquet cursus et neque vel sodales
								ligula”</p>
							<span class="number-font uppercase author-comment">iryna petrunco </span><span class="des-font capital model">/ model</span>
						</div>
						<!--  -->
						<div class="content-comment relative">
							<div class="number-font absolute stt-comment">#04</div>
							<p class="menu-font des-comment space_bot_30">“Quisque condimentum ipsum at velit hendrerit
								venenatis. Donec luctus metus enim, nunced. Sed sit
								amet nisl id purus aliquet cursus et neque vel sodales
								ligula”</p>
							<span class="number-font uppercase author-comment">iryna petrunco </span><span class="des-font capital model">/ model</span>
						</div>
						<!--  -->

					</div>
				</div>
			</div>

		</div>
	</div>
	<!--  -->
	<div class="container collection-home3 space_top_bot_150">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
				<div class="collection-content relative over-hidden margin_bottom_20">
					<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_collection1_home3.jpg" class="img-responsive hover-zoom-out" alt=""></a>
					<div class="absolute title-collection title-1">
						<h2 class="title-font"><a href="#" class="link-default">New collection 2018</a></h2>
						<p class="des-font space_bot_50">Quisque condimentum ipsum at velit hendrerit venenatis.</p>
						<p class=""><a href="#" class="uppercase menu-font">discover more</a></p>
					</div>
				</div>

				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 clear-space-left">
					<div class="collection-content relative over-hidden">
						<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_collection2_home3.jpg" class="img-responsive hover-zoom-out" alt=""></a>
						<div class="absolute title-collection title-2">
							<h2 class="title-font"><a href="#" class="link-default">Hats</a></h2>
							<p class="des-font space_bot_50">Quisque condimentum ipsum at velit hendrerit venenatis.</p>
							<p><a href="#" class="uppercase menu-font">discover more</a></p>
						</div>
					</div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 clear-space-right clear-none">
					<div class="collection-content relative over-hidden">
						<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_collection3_home3.jpg" class="img-responsive hover-zoom-out" alt=""></a>
						<div class="absolute title-collection title-2">
							<h2 class="title-font"><a href="#" class="link-default">Accesories</a></h2>
							<p class="des-font space_bot_50">Quisque condimentum ipsum at velit hendrerit venenatis.</p>
							<p><a href="#" class="uppercase menu-font">discover more</a></p>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
				<div class="collection-content relative over-hidden">
					<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_collection4_home3.jpg" class="img-responsive hover-zoom-out" alt=""></a>
					<div class="absolute title-collection title-3">
						<h2 class="title-font"><a href="#" class="link-default">Clothings</a></h2>
						<p class="des-font space_bot_50">Quisque condimentum ipsum at velit hendrerit venenatis.</p>
						<p><a href="#" class="uppercase menu-font">discover more</a></p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!--  -->
	<div class="container container_250 brand margin_bottom_150">
		<div class="brand-slider">
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand1.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand2.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand3.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand4.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand5.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand6.png" alt=""></a>
			</div>
			<div>
				<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/brand1.png" alt=""></a>
			</div>
		</div>
	</div>
	<!--  -->
	<div class="container margin_bottom_130 section-bestseller-home1">
		<div class="row">
			<div class="col-md-12">
				<h1 class="title-font margin_bottom_10 title-bestseller"><?= Lang::get("Featured product") ?></h1>
				<p class="des-font margin_bottom_50 des-bestseller"><?= Lang::get("Tôi thậm chí không biết rằng có tốt hơn không
điều kiện để trốn thoát, nhưng tôi đã sẵn sàng hơn
để có cơ hội của tôi trong số những người thời trang sau.") ?></p>
				<div class="slick-bestseller">
					<?php
					foreach ($productFeatureds as $product) {
						$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images) [0]);
						$url = ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->name));
						?>
						<div class="product">
							<div class="img-product relative">
								<a href="<?= $url ?>"><img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" class="img-responsive" alt="<?= $product->name ?>"></a>
								<figure class="absolute uppercase label-new title-font text-center"><?= Lang::get("Mới") ?></figure>
								<figure class="absolute uppercase label-sale title-font text-center">sale</figure>
								<div class="product-icon text-center absolute">
									<a href="#" onclick="getDetailProductModal(<?= $product->id ?>);return false;" class="icon-addcart inline-block enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></a>
									<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
									<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
										<i class="ti-more-alt"></i>
									</a>
								</div>
							</div>
							<div class="info-product text-center">
								<div class="info-product text-center">
									<h4 class="des-font capital title-product space_top_20">
										<a href="<?= $url ?>" title="<?= $product->seoTitle ?>"><?= $product->seoTitle ?></a>
									</h4>
									<p class="number-font price-product">
										<span class="price"><?= ControllerHelper::showProductPrice($product->price) ?></span>
									</p>
									<p class="des-font des-product"><?= $product->seoDescription ?></p>
								</div>
							</div>
						</div>
						<?php
					}
					?>
				</div>
				<div class="col-md-12 text-center discover-link margin_top_70">
					<a href="#" class="menu-font uppercase relative"><?= Lang::get("Xem thêm") ?>
						<figure class="line"></figure>
					</a>
				</div>
			</div>
		</div>
	</div>
	<!--  -->
	<div class="container newsletter-home3 space_top_bot_150">
		<h1 class="title-font capital title-newsletter text-center"><?= Lang::get("Nhập email của bạn để nhận được ưu đãi") ?></h1>
		<p class="des-font des-newsletter space_bot_60 text-center"><?= Lang::get("Giảm 20% khi bạn đăng ký tại đây") ?></p>
		<form id="newsletter-form" class="form-group des-font flex" method="post" onsubmit="return false;">
			<?php
			$text = new TextInput();
			$text->type = "Text";
			$text->name = "subscriber[firstName]";
			$text->value = $subscriber->firstName;
			$text->placeholder = Lang::get("Tên của bạn");
			$text->render();

			$text = new TextInput();
			$text->type = "text";
			$text->name = "subscriber[email]";
			$text->value = $subscriber->email;
			$text->required = "required";
			$text->placeholder = Lang::get("Nhập email của bạn");
			$text->errorMessage = RequestUtil::getFieldError("subscriber[email]");
			$text->hasError = RequestUtil::isFieldError("subscriber[email]");
			$text->render();

			$button = new Button();
			$button->type = "submit";
			$button->id = "";
			$button->title = Lang::get('Gửi đi');
			$button->attributes = "onclick=\" addSubscriber()\"";
			$button->class = "button_subscriber menu-font uppercase";
			$button->render();
			?>
		</form>
	</div>
	<!--  -->
	<div class="insta_home3 container margin_bottom_120">
		<div class="column-20 relative">
			<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_insta_home3_1.jpg" class="img-responsive full-width" alt=""></a>
			<div class="absolute icon-insta text-center">
				<a href="#"><i class="ti-instagram"></i></a>
			</div>
		</div>
		<div class="column-20 relative">
			<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_insta_home3_2.jpg" class="img-responsive full-width" alt=""></a>
			<div class="absolute icon-insta text-center">
				<a href="#"><i class="ti-instagram"></i></a>
			</div>
		</div>
		<div class="column-20 relative">
			<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_insta_home3_3.jpg" class="img-responsive full-width" alt=""></a>
			<div class="absolute icon-insta text-center">
				<a href="#"><i class="ti-instagram"></i></a>
			</div>
		</div>
		<div class="column-20 relative">
			<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_insta_home3_4.jpg" class="img-responsive full-width" alt=""></a>
			<div class="absolute icon-insta text-center">
				<a href="#"><i class="ti-instagram"></i></a>
			</div>
		</div>
		<div class="column-20 relative">
			<a href="#"><img src="http://landing.engotheme.com/html/nixx/demo/asset/img/img_insta_home3_5.jpg" class="img-responsive full-width" alt=""></a>
			<div class="absolute icon-insta text-center">
				<a href="#"><i class="ti-instagram"></i></a>
			</div>
		</div>
	</div>