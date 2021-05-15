<?php
use common\persistence\base\vo\ProductAttributeVo;
use core\Lang;
use core\utils\RequestUtil;
$productAttribute = new ProductAttributeVo();
if(!is_null(RequestUtil::get("productAttribute"))){
	$productAttribute = RequestUtil::get("productAttribute");
}

$disiableUpdate = " disabled ";
if(!is_null(RequestUtil::get("isEnableEditPrice"))) {
	$disiableUpdate = RequestUtil::get("isEnableEditPrice");
}

if (RequestUtil::hasActionMessages()) {
	?>
	<div id="alert_info" class="alert alert-info" role="alert">
		<?= RequestUtil::getActionMessage() ?>
	</div>
	<?php
}
if (RequestUtil::hasActionErrors()) {
	?>
	<div class="alert alert-danger" role="alert">
		<?= RequestUtil::getErrorMessage(); ?>
	</div>
	<?php
}
?>
<div class="attr-item">
	<div class=" col-md-2"><?= Lang::get("Quantity:") ?> </div>
	<div class="list-attr col-md-10">
		<input type="number" value="<?=$productAttribute->quantity?>" <?=$disiableUpdate?> class="form-control form-filter input-sm" name="productAttribute[quantity]"  />
	</div>
	<div class="clearfix"></div>
</div>
<div class="attr-item">
	<div class=" col-md-2"><?= Lang::get("Price:") ?> </div>
	<div class="list-attr col-md-10">
		<input type="number" <?=$disiableUpdate?> value="<?=$productAttribute->price?>" class="form-control form-filter input-sm" name="productAttribute[price]" />
	</div>
	<div class="clearfix"></div>
</div>
<div class="attr-item">
	<div class=" col-md-2"><?= Lang::get("Action:") ?> </div>
	<div class="list-attr col-md-10">
		<button type="button" <?=$disiableUpdate?> onclick="updateProductAttribute()" class="btn btn-sm blue margin-bottom-5 margin-top-5"><?=Lang::get("Set Price") ?></button>
	</div>
	<div class="clearfix"></div>
</div>