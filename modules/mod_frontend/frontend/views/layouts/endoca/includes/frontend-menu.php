<?php
use common\helper\LocalizationHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use common\rule\url\friendly\CategoryUrlFriendly;
use common\rule\url\friendly\ShortCategoryUrlFriendly;
use common\template\extend\Button;
use core\Controller;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\utils\SessionUtil;
use frontend\common\Constants;
use frontend\controllers\ControllerHelper;
use common\rule\url\friendly\CategoryBlogUrlFriendly;
$loginCustomerInfo = SessionUtil::get(Constants::CUSTOMER_LOGIN_SESSION_NAME);
$languages = RequestUtil::get('languages');
$language = RequestUtil::get("language");
$languageCode = RequestUtil::get('languageCode');
$categories = RequestUtil::get('categories');
$categorysBlog = RequestUtil::get('categoryBlogMenu');
?>
<nav class="collapse navbar-collapse bs-navbar-collapse" role="navigation" id="responsive-menu" style="display: none;">
    <div class="navbar-nav-wrap">
        <div class="right-side">
            <a class="contact-link" href="<?= ActionUtil::getFullPathAlias("home/contact", new AliasUrlFriendly("contact")) ?>"><?= Lang::get('Get in touch with us') ?> </a>
            <div class="btn-group languages rel">
                <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                    <span><img src="<?= AppUtil::resource_url("global/img/flags/" . strtolower($language->flag) . ".png")?>" alt="<?=$language->code?>" title="<?=$language->code?>"/></span> <?= strtoupper($languageCode) ?>
                    <span class="sprite language-arrow"></span>
                </button>
                <ul class="dropdown-menu" role="menu">
					<?php
					if (!empty ($languages)) {
						foreach ($languages as $lang) {
							?>
                            <li>
                                <a href="javascript:void(0);" onclick="changeLanguage('<?= $lang->code ?>');">
                                    <img src="<?= AppUtil::resource_url("global/img/flags/" . strtolower($lang->flag) . ".png") ?>"  alt="<?=$lang->code?>" title="<?=$lang->code?>"/> <?= strtoupper($lang->code) ?>
                                </a>
                            </li>
							<?php
						}
					}
					?>
                </ul>
            </div>
			<?php
			if (!is_null($loginCustomerInfo) && $loginCustomerInfo->userId != 0) {
				$button = new Button ();
				if ($loginCustomerInfo->isSaleRepChild) {
					$button->class = "login dropdown-toggle red";
				} else {
					$button->class = "login dropdown-toggle";
				}
				$button->attributes = 'data-toggle="dropdown"';
				if ($loginCustomerInfo->isSaleRepChild) {
					$button->title = "<span>" . $loginCustomerInfo->saleRepChildName . "<span class=\"caret\"></span></span>";
				} else {
					$button->title = "<span>" . $loginCustomerInfo->firstName . "<span class=\"caret\"></span></span>";
				}
				$button->render();
				?>
                <ul class="dropdown-menu" role="menu" id="user-login-menu">
                    <li>
                        <a href="<?= ActionUtil::getFullPathAlias("customer/detail") ?>"><?= Lang::get('Account Info') ?></a>
                    </li>
                    <li>
                        <a href="<?= ActionUtil::getFullPathAlias("home/address/list") ?>"><?= Lang::get('My Addresses') ?></a>
                    </li>
                    <li>
                        <a href="<?= ActionUtil::getFullPathAlias("customer/order/list") ?>"><?= Lang::get('My Orders') ?></a>
                    </li>
					<?php if ($loginCustomerInfo->accountTypeId == 2) { ?>
                        <li>
                            <a href="<?= ActionUtil::getFullPathAlias("customer/salesrep", new AliasUrlFriendly("reseller")) ?>#orders"><?= Lang::get('Sales Rep Center') ?></a>
                        </li>
					<?php } ?>
                    <li>
                        <a href="#" onclick="javascript:showLogoutDialog()"><?= Lang::get('Logout') ?></a>
                    </li>
                </ul>
				<?php
			} else {
				$button = new Button ();
				$button->class = "login dropdown-toggle";
				$button->attributes = 'data-toggle="modal" onclick="javascript:showLoginDialog()"';
				$button->title = Lang::get("Login");
				$button->render();
			}
			?>
            <div style="clear: both;"></div>
        </div>
        <ul class="nav navbar-nav">
            <li class="active open">
                <a href="<?= ActionUtil::getFullPathAlias("/", new AliasUrlFriendly("")) ?>"><?= Lang::get('Home') ?></a>
            </li>
            <li class="page-menu">
                <a href="<?= ActionUtil::getFullPathAlias("home/about/us", new AliasUrlFriendly("gioi-thieu")) ?>">
                    <span class="show-hide responsive-arrow"></span><?= Lang::get('About Us') ?>
                </a>
                <!--<div class="dropdown-menu" style="top: 160px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul>
                                    <li>
                                        <a href="<?/*= ActionUtil::getFullPathAlias("home/endoca/lifestyle", new AliasUrlFriendly("endoca-lifestyle")) */?>"><?/*= Lang::get('Endoca Lifestyle') */?></a>
                                    </li>
                                    <li>
                                        <a href="<?/*= ActionUtil::getFullPathAlias("home/live/in/balance", new AliasUrlFriendly("cbd-relax")) */?>"><?/*= Lang::get('Live In Balance') */?></a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>-->
            </li>
            <li class="page-menu">
                <a href="<?= ActionUtil::getFullPathAlias("home/quality/control", new AliasUrlFriendly("quy-chuan-chat-luong")) ?>">
                    <span class="show-hide responsive-arrow"></span><?= Lang::get('Quality Guarantee') ?>
                </a>
            </li>
            <li class="page-menu">
                <a href="<?= ActionUtil::getFullPathAlias("home/faq", new AliasUrlFriendly("faq")) ?>">
                    <span class="hover-arrow"></span><?= Lang::get('FAQ') ?></a>
            </li>
	        <li class="page-menu">
		        <a href="<?= ActionUtil::getFullPathAlias("home/blog/list", new AliasUrlFriendly("tin-tuc")) ?>">
			        <span class="hover-arrow"></span><?= Lang::get('Tin tức') ?></a>
		        <div class="dropdown-menu" style="top: 160px;">
			        <div class="container">
				        <div class="row">
					        <div class="col-xs-12">
						        <ul>
							        <?php
							        if (!empty ($categorysBlog)) {
								        foreach ($categorysBlog as $category) {
									        ?>
									        <li>
									        <a href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $category->id, new CategoryBlogUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
									        <?php
									        if(count($category->listChild)){
										        echo "<ul class='sub-menu'>";
										        foreach ($category->listChild as $item) {
											        ?>
											        <li>
												        <a href="<?= ActionUtil::getFullPathAlias("category/blog/detail?categoryId=" . $item->id, new CategoryBlogUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"><?= $item->name ?></a>
											        </li>
											        <?php
										        }
										        echo "</ul>";
									        }
									        ?>
									        </li>
									        <?php
								        }
							        }
							        ?>
						        </ul>
					        </div>
				        </div>
			        </div>
		        </div>
	        </li>
            <li>
                <a href="<?= ActionUtil::getFullPathAlias("category/list", new AliasUrlFriendly("products")) ?>">
                    <span class="show-hide responsive-arrow"></span><?= Lang::get('Shop') ?>
                </a>
                <div class="dropdown-menu" style="top: 160px;">
                    <div class="container">
                        <div class="row">
                            <div class="col-xs-12">
                                <ul>
							        <?php
							        if (!empty ($categories)) {
								        foreach ($categories as $category) {
									        ?>
                                            <li>
                                                <a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $category->id, new CategoryUrlFriendly($category->languageCode, $category->id, $category->seoUrl, $category->name)) ?>"><?= $category->name ?></a>
                                            <?php 
                                            if(count($category->listChild)){
                                            echo "<ul class='sub-menu'>";
                                            	foreach ($category->listChild as $item) {
                                            ?>
                                            	<li>
	                                            	<a href="<?= ActionUtil::getFullPathAlias("category/detail?categoryId=" . $item->id, new CategoryUrlFriendly($item->languageCode, $item->id, $item->seoUrl, $item->name)) ?>"><?= $item->name ?></a>
                                            	</li>
                                            <?php 
                                            	}
                                            echo "</ul>";
                                            }
                                            ?>
                                            </li>
									        <?php
								        }
							        }
							        ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</nav>
<script type="text/javascript">
	<?php
	$url = null;
	if (RouteUtil::getRoute()->getPath() === "category/detail") {
		$categoryId = RequestUtil::get("categoryId");
		if (!AppUtil::isEmptyString($categoryId)) {
			$url = ActionUtil::getFullPathAlias("category/detail", new ShortCategoryUrlFriendly($categoryId));
		}
	}

	?>

	var currentURL = "<?=!is_null($url) ? $url : RouteUtil::getRoute()->getWebRoot() . "/" . LocalizationHelper::getLangCode() . "/" . ControllerHelper::getRequestActionPath()?>";
	var selector = $('ul.navbar-nav a[href="' + currentURL + '"]');
	var li = selector.parents('li:last');
	li.siblings().attr("class", "");
	li.children("a").append("<span class=\"hover-arrow\"></span>");
	li.addClass('active open');
	if (selector.closest("li").children("div").length <= 0) {
		selector.closest("li").siblings().attr("class", "");
		selector.closest("li").attr("class", "active");
	}

	//add page-has-submenu
	$('.navbar-nav-wrap ul li.page-menu.active.open').parents('.navbar-static-top').addClass('page-has-submenu');

	$("#user-login-menu li a").on("click", function(e){
		e.preventDefault();
		var href = $(this).attr("href");
		var url = href.split("#")[0];
		window.location.href = href;
		if (url == currentURL) {
			location.reload(true);
		}
	});
	function changeLanguage(lang){
		var url = "<?=ActionUtil::getFullPathAlias("language/change")?>?rtype=json";
		var data =
			{
				"langCode": lang,
				"url": window.location.href
			};
		simpleAjaxPost(guid(), url, data, onChangeLanguageSuccess);
	}
	function onChangeLanguageSuccess(res){
		window.location.href = res.extra.url;
	}
	function changeRegion(obj){
		currentUrl = window.location.href;
		var data = {"regionId": obj.value};
		$.ajax({
			type: 'POST',
			url: "<?=ActionUtil::getFullPathAlias("region/change")?>?rtype=json",
			data: data,
			async: true
		})
			.done(function(){
				window.location.href = currentUrl;
			});
	}
</script>