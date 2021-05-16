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
			<div class="jss24">
				<div class="desktop-action"><a class="MuiButtonBase-root MuiButton-root MuiButton-text jss33 jss44 jss46 jss45" tabindex="0" aria-disabled="false" data-testid="Button-root" href="https://pro.housecallpro.com/pro/log_in"><span class="MuiButton-label">Login</span><span class="MuiTouchRipple-root"></span></a></div>
				<div class="desktop-action">
					<div class="jss25 jss47" data-testid="Form-root">
						<form data-testid="FreeTrialEmailForm-root" class="jss55 jss25">
							<div class="MuiFormControl-root MuiTextField-root jss65 jss56 jss62">
							<div class="MuiInputBase-root MuiOutlinedInput-root jss67 MuiInputBase-formControl">
								<input type="email" aria-invalid="false" id="EmailForm-Field-email" name="email" placeholder="Enter your email" value="" data-testid="EmailForm-Field-email" aria-label="Email" class="MuiInputBase-input MuiOutlinedInput-input jss66 jss72 jss57 jss62">
								<fieldset aria-hidden="true" style="padding-left:8px" class="jss73 MuiOutlinedInput-notchedOutline">
									<legend class="jss74" style="width:0.01px"><span>&#8203;</span></legend>
								</fieldset>
							</div>
							</div>
							<button class="MuiButtonBase-root MuiButton-root jss58 jss63 MuiButton-contained jss33 jss34 jss45 MuiButton-containedPrimary MuiButton-disableElevation" tabindex="0" type="submit" data-testid="EmailForm-button"><span class="MuiButton-label">Start Free Trial</span><span class="MuiTouchRipple-root"></span></button>
						</form>
					</div>
				</div>
			</div>
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
                <a href="<?= ActionUtil::getFullPathAlias("price") ?>">
                    <span class="show-hide responsive-arrow"></span><?= Lang::get('Price') ?>
                </a>
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