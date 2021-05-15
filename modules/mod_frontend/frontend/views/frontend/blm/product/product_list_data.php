<?php

use api\controllers\ControllerHelper;
use common\helper\DatoImageHelper;
use common\rule\url\friendly\ProductUrlFriendly;
use common\template\extend\PagingTemplate;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$productCategory = RequestUtil::get('productCategories');
$products = $productCategory->records;
?>
<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-shop full-shop">
		<div class="row btn-function-shop">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 margin_bottom_50">
				<span class="des-font showing hidden-xs">Showing 1–9 of 50 results</span>
				<button class="active" id="btn-grid"><i class="ti-layout-grid3-alt"></i></button>
				<button id="btn-list"><i class="ti-list"></i></button>
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 margin_bottom_50 text-right select-view">
				<button><i class="ti-eye"></i></button>
				<select id="select-show">
					<option><?= Lang::get("Sếp theo phổ biến nhất") ?></option>
					<option><?= Lang::get("Sếp theo nổi bật nhất") ?></option>
					<option><?= Lang::get("Sếp theo bán chạy nhất") ?></option>
					<option><?= Lang::get("Sếp theo chữ cái A-Z") ?></option>
					<option><?= Lang::get("Sếp theo giá tăng dần") ?></option>
					<option><?= Lang::get("Sếp theo giá giảm dần") ?></option>
				</select>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 content-shop full-shop">
				<?php
				foreach ($products as $product) {
					$imageMo = DatoImageHelper::getImageInfoById(json_decode($product->images)[0]);
					$url = ActionUtil::getFullPathAlias("product/detail?id=$product->id", new ProductUrlFriendly($product->languageCode, $product->id, $product->seoUrl, $product->seoTitle));
					?>
					<div class="product col-lg-2 col-md-4 col-sm-6 col-xs-6 margin_bottom_50">
						<div class="img-product relative">
							<a href="<?= $url ?>" title="<?= $product->seoTitle ?>"><img src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>" class="img-responsive" alt="<?= $product->seoTitle ?>"></a>
							<figure class="absolute uppercase label-new title-font text-center"><?= Lang::get("Mới") ?></figure>
							<div class="product-icon text-center absolute">
								<a href="#" onclick="getDetailProductModal(<?= $product->id ?>);return false;" class="icon-addcart inline-block enj-add-to-cart-btn btn-default"><i class="ti-bag"></i></a>
								<a href="#" class="icon-heart inline-block"><i class="ti-heart"></i></a>
								<a href="#" class="engoj_btn_quickview icon-quickview inline-block" title="quickview">
									<i class="ti-more-alt"></i>
								</a>
							</div>
						</div>
						<div class="product-info">
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
			<?php
			$pagingTemplate = new PagingTemplate();
			$pagingTemplate->paging = $productCategory;
			$pagingTemplate->changePageJs = "changePageProduct";
			$pagingTemplate->render();
			?>
		</div>
	</div>
</div>
