<?php
use common\template\extend\Button;
use core\Lang;

?>
<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
	<h4 class="modal-title"><?=Lang::get("Region payment method configuration")?></h4>
</div>
<div class="modal-body">
	<?php include_once 'bank_transfer_config_edit_form_data.php'; ?>
</div>
<div class="modal-footer">
	<?php
	$button = new Button();
	$button->type = "button";
	$button->id = "btnEditPaymentMethodSetting";
	$button->title = " " . Lang::get ( "Save" );
	$button->class = "btn green";
	$button->attributes = "";
	$button->render ();
	
	$button = new Button ();
	$button->type = "button";
	$button->id = "";
	$button->title = " " . Lang::get ( "Close" );
	$button->class = "btn btn-sm grey margin-bottom-5";
	$button->attributes = "data-dismiss=\"modal\"";
	$button->render ();
	?>
</div>