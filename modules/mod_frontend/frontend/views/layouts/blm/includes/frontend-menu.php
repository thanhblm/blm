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


<ul class="nav navbar-nav menu-font menu-main menu-home3">
	<?php
	if (!empty ($categories)) {
		foreach ($categories as $category) {
			?>
			<li class="relative dropdown">
				<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>" class="link-menu delay03 uppercase"><?= $category->name ?></a>
				<figure class="line absolute delay03"></figure>
				<?php
				if (count($category->listChild)) {
					?>
					<div class="dropdown-menu mega-menu-main absolute space_30 space_top_bot_50 text-left">
						<div class="container_15">
							<div class="row">
								<div class="col-lg-6 col-md-6 border-right">
									<ul class="clear-space capital lv1">
										<?php
										foreach ($category->listChild as $item) {
											?>
											<li class="margin_bottom_20 space_left_20 uppercase">
												<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $item->id, new CategoryUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"><?= $item->name ?></a>
											</li>
										<?php } ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<?php
				}
				?>
			</li>
			<?php
		}
	}
	?>
	<li class="relative dropdown">
		<a href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>" class="link-menu delay03 uppercase"><?= Lang::get("Sự kiện") ?></a>
		<figure class="line absolute delay03"></figure>
		<div class="dropdown-menu mega-menu-main absolute space_30 space_top_bot_50 text-left">
			<div class="container_15">
				<div class="row">
					<div class="col-lg-6 col-md-6 border-right">
						<ul class="clear-space capital lv1">
							<li class="margin_bottom_20 space_left_20 uppercase">blog page</li>
							<?php
							foreach ($categorysBlog as $item) {
								?>
								<li class="menu-child-font">
									<a href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $item->id, new CategoryBlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"><?= $item->name ?></a>
								</li>
							<?php } ?>
						</ul>
					</div>
					<div class="col-lg-6 col-md-6">
						<ul class="capital lv1 space_left_30">
							<li class="margin_bottom_20 space_left_20 uppercase">blog detail
								page
							</li>
							<li class="menu-child-font">
								<a href="Blog_detail_right_sidebar.html">blog
									detail right sidebar</a></li>
							<li class="menu-child-font"><a href="Blog_detail_left_sidebar.html">blog
									detail left sidebar</a></li>
							<li class="menu-child-font"><a href="Blog_detail_no_sidebar.html">blog
									detail full width</a></li>
							<li class="menu-child-font"><a href="#">blog detail 4 - Comming
									soon</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</li>
	<!--<li class="relative dropdown">
		<a href="#" class="link-menu delay03 uppercase"><?/*= Lang::get("FAQs page") */?></a>
		<figure class="line absolute delay03"></figure>
		<div class="dropdown-menu mega-menu-main absolute space_30 space_top_bot_50 text-left">
			<div class="container_15">
				<div class="row">
					<div class="col-lg-6 col-md-6 border-right">
						<ul class="clear-space capital lv1">
							<li class="margin_bottom_20 space_left_20 uppercase">page set 1</li>
							<li class="menu-child-font"><a href="About_page_1.html">about page
									1</a>
							</li>
							<li class="menu-child-font"><a href="About_page_2.html">about page
									2</a>
							</li>
							<li class="menu-child-font"><a href="FAQ.html">FAQs page</a></li>
							<li class="menu-child-font"><a href="404.html">404 page</a></li>
						</ul>
					</div>
					<div class="col-lg-6 col-md-6">
						<ul class="capital lv1 space_left_30">
							<li class="margin_bottom_20 space_left_20 uppercase">page set 2</li>
							<li class="menu-child-font"><a href="cart_page.html">cart page</a>
							</li>
							<li class="menu-child-font"><a href="wishlist_page.html">wishlist
									page</a>
							</li>
							<li class="menu-child-font"><a href="login_page.html">login/register
									page</a></li>
							<li class="menu-child-font"><a href="#">other page - comming
									soon</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</li>-->
	<li class="relative">
		<a href="#" class="link-menu delay03 uppercase"><?= Lang::get("Liên hệ") ?></a>
		<figure class="line absolute delay03"></figure>
	</li>
</ul>
