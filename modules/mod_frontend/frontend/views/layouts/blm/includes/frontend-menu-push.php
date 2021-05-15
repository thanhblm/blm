<?php

use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
use common\rule\url\friendly\CategoryUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\RequestUtil;

$categorysBlog = RequestUtil::get('categoryBlogMenu');
$categories = RequestUtil::get("categories");
?>

<div class="pushmenu menu-home5">
	<div class="menu-push">
		<span class="close-left js-close"><i class="ti-close"></i></span>
		<div class="clearfix"></div>
		<form role="search" method="get" id="searchform" class="searchform title-font" action="/search">
			<div>
				<label class="screen-reader-text" for="q"></label>
				<input type="text" placeholder="<?= Lang::get("Tìm sản phẩm") ?>" value="" name="q" id="q" autocomplete="off">
				<input type="hidden" name="type" value="product">
				<button type="submit" id="searchsubmit"><i class="ti-search"></i></button>
			</div>
		</form>
		<ul class="nav-home5 js-menubar clear-space menu-font">
			<?php
			if (!empty ($categories)) {
				foreach ($categories as $category) {
					?>
					<li class="level1 active dropdown">
						<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>" class="uppercase"><?= $category->name ?></a>
						<span class="icon-sub-menu"></span>
						<?php
						if (count($category->listChild)) {
							?>
							<div class="menu-level1 js-open-menu">
								<ul class="level1">
									<?php
									foreach ($category->listChild as $item) {
										?>
										<li class="level2">
											<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $item->id, new CategoryUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>" class="capital"><?= $item->name ?></a>
										</li>
									<?php } ?>
								</ul>
							</div>
							<?php
						}
						?>
					</li>
					<?php
				}
			}
			?>
			<li class="level1 active dropdown">
				<a href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>" class="uppercase"><?= Lang::get("Sự kiện") ?></a>
				<span class="icon-sub-menu"></span>
				<div class="menu-level1 js-open-menu">
					<ul class="level1">
						<?php
						foreach ($categorysBlog as $item) {
							?>
							<li class="level2">
								<a class="capital" href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $item->id, new CategoryBlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"><?= $item->name ?></a>
							</li>
						<?php } ?>
					</ul>
				</div>
			</li>
			<li class="level1">
				<a href="#" class="uppercase"><?= Lang::get("Liên Hệ") ?></a>
			</li>
			<li>
				<a href="#" class="inline-block uppercase"><i class="zoa-icon-user space_right_10"></i><?= Lang::get("Tài khoản") ?>
				</a>
			</li>
		</ul>
	</div>
</div>