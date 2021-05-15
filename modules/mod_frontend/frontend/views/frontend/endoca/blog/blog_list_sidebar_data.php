<?php
use common\template\extend\PagingTemplate;
use core\utils\RequestUtil;
use common\helper\DatoImageHelper;
use core\utils\ActionUtil;
use core\utils\AppUtil;
use core\Lang;
use common\rule\url\friendly\BlogUrlFriendly;

$paging = RequestUtil::get ( "blogList" );
$blogList = $paging->records;
$filter = RequestUtil::get ( "filter" );
?>
<div id="MiddleMainContent" class="t_right">
	<div class="container-common">
		<div id="ctl26_HeaderContainer" class="box-header">
			<div class="name_tit" align="center">
				<h2 style="color: White; font-weight: bold; text-align: center;">Tin nhiều người đọc</h2>
			</div>
		</div>
		<div id="ctl26_BodyContainer" class="bor_box">
			<?php $i=0;
			foreach ($blogList as $item) {
				$imageMo = DatoImageHelper::getImageInfoById(json_decode($item->images)[0]);
			?>
			<div style="padding: 5px; width: 60px; height: 55px; float: left;">
				<div class="many-readers-title-icon">
					<a title="<?=$item->name?>" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->url, $item->name)) ?>"> <img style="width: 60px; height: 55px;" src="<?= DatoImageHelper::getMediumImageUrl($imageMo) ?>">
					</a>
				</div>
			</div>
			<div class="data-default-CSSClass">
				<p style="padding: 0px; margin: 5px 5px 0 0;">
					<a class="controls-view-date-contents-link" href="<?= ActionUtil::getFullPathAlias("home/blog/detail?id=$item->id", new BlogUrlFriendly($item->languageCode, $item->id, $item->url, $item->name)) ?>" title="<?=$item->name?>"> <?=$item->name?></a>
				</p>
			</div>
			<div style="clear: both;"></div>
			<?php }?>
		</div>
		<div id="ctl26_FooterContainer"></div>
	</div>
	<div style="clear: both; margin-bottom: 10px;"></div>
	<div class="container-common">
		<div id="ctl27_HeaderContainer" class="box-header">
			<div class="name_tit" align="center">
				<h2 style="color: White;">Chủ đề được quan tâm</h2>
			</div>
		</div>
		<div id="ctl27_BodyContainer" class="bor_box">
			<div class="list">
				<ul>
					<li><h3 class="normal">
							<a href="/thi-truong-nha-dat-dong-anh" title="Thị trường nhà đất Đông Anh"> Thị trường nhà đất Đông Anh</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/can-ho-25m2" title="Căn hộ 25m2"> Căn hộ 25m2</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/thi-truong-bat-dong-san-2018" title="Thị trường bất động sản 2018"> Thị trường bất động sản 2018</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/bao-ve-nguoi-mua-nha-dat" title="Bảo vệ người mua nhà, đất"> Bảo vệ người mua nhà, đất</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/can-ho-officetel" title="Căn hộ Officetel"> Căn hộ Officetel</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/thi-truong-dat-nen" title="Thị trường đất  nền"> Thị trường đất nền</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/sot-dat-tphcm" title="Sốt đất Tp.HCM năm 2017"> Sốt đất Tp.HCM năm 2017</a>
						</h3></li>
					<li><h3 class="normal">
							<a href="/thi-truong-bat-dong-san-2017" title="Thị trường bất động sản 2017"> Thị trường bất động sản 2017</a>
						</h3></li>
				</ul>
			</div>
			<div style="padding-left: 20px; padding-top: 5px; border-top: 1px solid #ccc; margin-top: 10px;">
				<a href="/chu-de-trong-chu-de-ve-thong-tin-thi-truong" class="linktoall">Xem tất cả</a>
			</div>
		</div>
		<div id="ctl27_FooterContainer"></div>
	</div>
	<div style="clear: both; margin-bottom: 10px;"></div>
	<link rel="stylesheet" type="text/css" href="https://content.batdongsan.com.vn/Modules/Support/images/styles/home.css" media="all">
	
	<div class="clear10"></div>
	<div style="clear: both;"></div>
</div>




