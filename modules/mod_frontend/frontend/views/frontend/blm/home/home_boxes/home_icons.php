<?php

use common\rule\url\friendly\AliasUrlFriendly;
use core\Lang;
use core\utils\ActionUtil;
use core\utils\AppUtil;

?>

<div class="content-line ngray">
	<div class="container trust_pilot_container">
		<div class="row">
			<div class="col-xs-12">
				<div class="col-xs-12 col-sm-3 trust_pilot_block"><p style="text-align:center">
						<img src="<?= AppUtil::resource_url("layouts/endoca.com/images/home/dich-vu-chuyen-nghiep.png") ?>" alt="<?= Lang::get("Dịch vụ chuyên nghiệp") ?>" title="<?= Lang::get("Dịch vụ chuyên nghiệp") ?>" width="50" height="50"><span class="qualityControlHead"><?= Lang::get("Dịch vụ chuyên nghiệp") ?></span>
					</p>
					<div class="qualityControlContent">
						<p style="text-align: center;"><?= Lang::get("Sbirds Việt Nam là công ty chuyên may in đồng phục cho Cá nhân và Doanh nghiệp tại Hải Phòng. Với quy trình sản xuất [...]") ?>
							-&nbsp;
							<a href="#"><?= Lang::get("Xem thêm") ?></a>
						</p>
					</div>
					<p></p>
				</div>
				<div class="col-xs-12 col-sm-3 trust_pilot_block"><p style="text-align:center">
						<img src="<?= AppUtil::resource_url("layouts/endoca.com/images/home/quy-trinh-san-xuat.png") ?>" alt="<?= Lang::get("Quy trình sản xuất") ?>" title="<?= Lang::get("Quy trình sản xuất") ?>" width="50" height="50"><span class="qualityControlHead"><?= Lang::get("Quy trình sản xuất") ?></span>
					</p>
					<div class="qualityControlContent">
						<p style="text-align: center;"><?= Lang::get("Bạn thân mến, để có được mẫu áo thun đồng phục đẹp, đội ngũ sản xuất của Sbirds phải trải qua [...]") ?>
							-&nbsp;
							<a href="<?= ActionUtil::getFullPathAlias("home/contact", new AliasUrlFriendly("contact")) ?>"><?= Lang::get("Xem thêm") ?></a>
						</p>
					</div>
					<p></p>
				</div>
				<div class="col-xs-12 col-sm-3 trust_pilot_block"><p style="text-align:center">
						<img src="<?= AppUtil::resource_url("layouts/endoca.com/images/home/dat-hang-don-gian.png") ?>" alt="<?=Lang::get("Đặt Hàng Đơn Giản")?>" title=" <?=Lang::get("Đặt Hàng Đơn Giản")?> " width="50" height="50"><span class="qualityControlHead"><?= Lang::get("Đặt hàng đơn giản") ?></span>
					</p>
					<div class="qualityControlContent">
						<p style="text-align: center;"><?= Lang::get("Bạn đang cần đặt áo đồng phục tại Sbirds 1 cách nhanh chóng và tiện lợi. Chỉ cần bạn thực hiện 5 bước [...]") ?>
							-&nbsp;
							<a href="<?= ActionUtil::getFullPathAlias("home/quality/control", new AliasUrlFriendly("quality-control")) ?>"><?= Lang::get("Xem thêm") ?></a>
						</p>
					</div>
					<p></p>
				</div>
				<div class="col-xs-12 col-sm-3 trust_pilot_block"><p style="text-align:center">
						<span class="qualityControlHead"><span class="trust_pilot_stars">★★★★★</span></span></p>
					<div class="qualityControlContent">
						<p style="text-align: center;"><?= Lang::get("Đánh giá thân thiện") ?>&nbsp;-<br>&nbsp;
							<a href="https://www.trustpilot.com/review/www.sbirds.vn" target="blank"><?= Lang::get("Xem đánh giá ") ?></a>
							&nbsp;<?= Lang::get("Để biết các bạn yêu thích Sbirds") ?>
						</p>
					</div>
					<p></p>
				</div>
			</div>
		</div>
	</div>
</div>