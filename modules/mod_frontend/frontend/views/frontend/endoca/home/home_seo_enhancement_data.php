<?php
use core\Lang;
use core\utils\SessionUtil;
?>
<div class="modal-dialog">
	<div class="t-alr">
        <button aria-hidden="true" data-dismiss="modal" class="close" type="button"></button>
    </div>
	<div class="modal-content">
		<div class="tabs-container">
			<div style="padding: 20px">
				<h3 style="text-align: center;">
					<?=Lang::get("Đặt hàng áo đồng phục ngay hôm nay")?></h3>
				<div style="text-align: center;">
					<?=Lang::get("Để được miễn phí vận chuyển")?></div>
				<br> <span><?=Lang::get('BONUS: Sbirds luôn hỗ trợ tư vấn cho khách hàng')?> </span> <br>
				<br>
				<div class="_buttons dt-buttons">
					<button type="button" id="btnLoginSubmit" class="wide" onclick="seoEnhancement()"><?= Lang::get("Truy cập cửa hàng!") ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function seoEnhancement(){
	window.open('<?= \core\utils\ActionUtil::getFullPathAlias("category/list", new \common\rule\url\friendly\AliasUrlFriendly("products")) ?>', '_blank');
}
</script>
<?php 
if(SessionUtil::get("seo_enhancement")==true){
	SessionUtil::set("seo_enhancement", false);
}
?>