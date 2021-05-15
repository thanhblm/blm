<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
$discountCoupon = RequestUtil::get ( "discountCoupon" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete system setting discountCoupon")?></h4>
</div>
<div class="modal-body">
	<form id="del_discount_coupon_form" class="form-horizontal" novalidate="novalidate">
		<input name="id" type="hidden" value="<?=$discountCoupon->id?>" />
		<div class="form-body">
			<p><?=Lang::getWithFormat("Are you sure you want to delete <b>{0}</b>?",$discountCoupon->name)?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnDelDiscountCoupon";
	$button->title = " " . Lang::get ( "Yes" );
	$button->class = "btn btn-sm blue margin-bottom-5";
	$button->attributes = "";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "No" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>