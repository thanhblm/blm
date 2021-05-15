<?php

use common\rule\url\friendly\AliasUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$productCategory = RequestUtil::get('productCategories');
$products = $productCategory->records;
$category = RequestUtil::get("category");
?>
<div class="banner margin_bottom_150">
	<div class="container">
		<h1 class="title-font title-banner"><?= Lang::get("Cửa hàng") ?></h1>
		<ul class="breadcrumb des-font">
			<li>
				<a title="<?= $titlePage ?>" href="<?= ActionUtil::getFullPathAlias("/", new AliasUrlFriendly("")) ?>"><?= Lang::get("Trang chủ") ?></a>
			</li>
			<?php
			if (!is_null($category)) {
				?>
				<li>
					<a title="<?= Lang::get("Cửa hàng") . " - " . $titlePage ?>" href="<?= ActionUtil::getFullPathAlias("category/list", new AliasUrlFriendly("products")) ?>"><?= Lang::get("Cửa hàng") ?></a>
				</li>
				<li class="active"><?= $category->name ?></li>
				<?php
			} else {
				?>
				<li class="active"><?= Lang::get("Cửa hàng") ?></li>
				<?php
			}
			?>
		</ul>
	</div>
</div>

<!--  -->
<div class="container shop-page margin_bottom_150" id="div_product_list">
	<?php include "product_list_data.php" ?>
</div>
<script type="text/javascript">
    var gUrlBlogList = "<?=ActionUtil::getFullPathAlias("home/category/list/search") ?>" + "?rtype=json";

    function changePageProduct(page) {
        simpleAjaxPost(
            guid(),
            gUrlBlogList + "&page=" + page,
            "",
            loadProductSuccess
        );
    }

    function loadProductSuccess(res) {
        $("#div_product_list").html(res.content);
    }
</script>