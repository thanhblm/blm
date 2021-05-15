<?php
use common\template\extend\Button;
use core\Lang;
use core\utils\RequestUtil;

$taxShippingZone = RequestUtil::get ( "taxShippingZone" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete Tax & Shipping Zones")?></h4>
</div>
<div class="modal-body">
	<form id="del_tax_shipping_zone_form" class="form-horizontal" novalidate="novalidate">
		<input name="id" type="hidden" value="<?=$taxShippingZone->id?>" />
		<div class="form-body">
			<p><?=Lang::getWithFormat("Are you sure you want to delete <b>{0}</b>?",$taxShippingZone->name)?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnSubmit";
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