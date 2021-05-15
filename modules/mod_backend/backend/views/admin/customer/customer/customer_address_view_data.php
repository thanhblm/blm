<?php
use core\Lang;
use common\template\extend\Button;
?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Customer Addresses")?></h4>
</div>
<div class="modal-body">
	<?php include_once 'customer_address_form_data.php'; ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "Close" );
	$button->class = "btn btn-sm btn-close margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>


