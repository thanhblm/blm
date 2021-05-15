<?php

use common\helper\SettingHelper;
use common\rule\url\friendly\AliasUrlFriendly;
use core\config\ModuleConfig;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\utils\RequestUtil;
use core\utils\RouteUtil;
use core\utils\SessionUtil;

$viewPath = ModuleConfig::getModuleConfig(RouteUtil::getRoute()->getModule()) ['VIEW_PATH'] . DS . "endoca" . DS;
$countOrderProduct = 0;
if (!empty (SessionUtil::get("listOrderProduct"))) {
	$countOrderProduct = count(SessionUtil::get("listOrderProduct")->getArray());
}
$region = RequestUtil::get('region');
?>
<header class="navbar navbar-static-top bs-docs-nav">
	<div class="jas-navigation">
		<!--<div class="jas-navigation-top">
			<div class="container">
				<a href="<?/*= ActionUtil::getFullPathAlias("home/why/choose/endoca", new AliasUrlFriendly("why-choose-endoca")) */?>">
					<img src="<?/*= AppUtil::resource_url("layouts/endoca.com/images/top_banner_1_new.png") */?>" alt="" width="1400" height="39">
				</a>
			</div>
		</div>-->
		<div class="jas-navigation-bottom">
			<div class="container">
				<div class="top-banner-2">
					<ul>
						<li class="jas-title"><span class="sprite small_person_icon img"></span>
							<a href="<?= ActionUtil::getFullPathAlias("home/contact", new AliasUrlFriendly("contact")) ?>"><?= Lang::get('Get in touch with us') ?> </a>
						</li>
						<li class="jas-sep"></li>
						<li class="jas-info"><span class="sprite small_phone_icon img"></span>
							<strong><?= Lang::get('US') ?></strong>
							<a href="tel:+1-123456789">+1-123456789</a>
						</li>
						<li class="jas-info"><span class="sprite small_phone_icon img"></span>
							<strong><?= Lang::get('VN') ?></strong>
							<a href="tel:+84 941406590">+84 941406590</a>
						</li>
						<li class="jas-info">
							<a href="mailto:info@haiphongdeveloper.com">
								<span class="sprite small_email_icon img"></span> <?= $region->contactEmail ?>
							</a>
						</li>
						<li class="jas-sub">
							<ul class="social">
								<li class="facebook">
									<a href="<?= SettingHelper::getSettingValue('Facebook') ?>"><?= Lang::get('Facebook') ?></a>
								</li>
								<li class="google">
									<a href="<?= SettingHelper::getSettingValue('Google Plus') ?>"><?= Lang::get('Google+') ?></a>
								</li>
								<li class="twitterbird">
									<a href="<?= SettingHelper::getSettingValue('Twitter') ?>"><?= Lang::get('Twitter') ?></a>
								</li>
								<li class="instagram">
									<a href="<?= SettingHelper::getSettingValue('Instagram') ?>"><?= Lang::get('Instagram') ?></a>
								</li>
								<li class="blog">
									<a href="<?= SettingHelper::getSettingValue('Blog') ?>"><?= Lang::get('Blog') ?></a>
								</li>
								<li class="youtube">
									<a href="<?= SettingHelper::getSettingValue('Youtube') ?>"><?= Lang::get('Youtube') ?></a>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div id="stickyNavigationContainer" class="responsive-parent navigationIndex">
		<div class="navigation-white"></div>
		<div class="container" style="padding-left: 0; padding-right: 0;">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" id="responsive-btn">
					<span class="sr-only"><?= Lang::get('Toggle navigation') ?></span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
				</button>
				<div class="load-tpc on-small-ex">
					<div class="top-card-container">
						<a href="<?= ActionUtil::getFullPathAlias("home/cart/checkout/view") ?>" class="top-card">
							<span class="cart-count"><?= $countOrderProduct ?></span><span class="icon small-card"></span></a>
						<div class="top-card-basket">
							<div class="load-tpcc">
								<div class="col-xs-12 fw_sidebar-container" style="margin-top:8px;">
									<div id="fw_sidebar">
										<div class="content rel">
											<div class="headline">
												<div class="fz18">
													<span class="fr icon basket"></span><?= Lang::get('Shopping') ?>
													<strong><?= Lang::get('Basket') ?></strong>
												</div>
											</div>
											<div class="shopping" id="fw_sidecart_contents">
												<?php include $viewPath . "cart" . DS . "add_to_cart_view_data.php"; ?>
											</div>
											<div class="clear"></div>
											<div class="wave "></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<a class="navbar-brand" href="<?= ActionUtil::getFullPathAlias("/", new AliasUrlFriendly("")) ?>"><span class="sprite logo"></span></a>
			</div>
			<?php include 'frontend-menu.php'; ?>
		</div>
	</div>
</header>

<div id="header-content"></div>