<?php
use core\utils\RequestUtil;
use core\Lang;
use common\template\extend\Button;
$order = RequestUtil::get ( "order" );
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Delete system setting order")?></h4>
</div>
<div class="modal-body">
	<form id="del_order_form" class="form-horizontal" novalidate="novalidate">
		<input name="id" type="hidden" value="<?=$order->id?>" />
		<div class="form-body">
			<p><?=Lang::get("Are you sure you want to delete this order ?")?></p>
		</div>
	</form>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnDelOrder";
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